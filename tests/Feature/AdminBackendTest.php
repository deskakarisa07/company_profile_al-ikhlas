<?php

namespace Tests\Feature;

use App\Models\Blog;
use App\Models\CompanyProfile;
use App\Models\ContactMessage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminBackendTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::create([
            'name' => 'Admin',
            'email' => 'admin@test.local',
            'password' => Hash::make('secret123'),
            'is_admin' => true,
        ]);
    }

    public function test_guest_cannot_access_dashboard(): void
    {
        $this->get('/admin/dashboard')->assertRedirect(route('admin.login'));
    }

    public function test_admin_can_login_and_logout(): void
    {
        $admin = $this->admin();

        $this->post('/admin/login', ['email' => $admin->email, 'password' => 'secret123'])
            ->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($admin);

        $this->post('/admin/logout')->assertRedirect(route('admin.login'));
        $this->assertGuest();
    }

    public function test_non_admin_is_rejected(): void
    {
        $user = User::create(['name' => 'User', 'email' => 'user@test.local', 'password' => Hash::make('secret123'), 'is_admin' => false]);

        $this->post('/admin/login', ['email' => $user->email, 'password' => 'secret123'])
            ->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_admin_can_create_article_with_image(): void
    {
        Storage::fake('public');

        $this->actingAs($this->admin())->post(route('admin.articles.store'), [
            'title' => 'Artikel Baru',
            'category' => 'Kegiatan',
            'description' => 'Isi artikel pengujian.',
            'status' => 'published',
            'image' => UploadedFile::fake()->image('artikel.jpg'),
        ])->assertRedirect(route('admin.articles.index'));

        $article = Blog::where('title', 'Artikel Baru')->firstOrFail();
        Storage::disk('public')->assertExists($article->image);
    }

    public function test_article_validation_is_applied(): void
    {
        $this->actingAs($this->admin())->post(route('admin.articles.store'), [])
            ->assertSessionHasErrors(['title', 'category', 'description', 'status', 'image']);
    }

    public function test_public_blog_only_displays_published_articles(): void
    {
        Blog::create(['title' => 'Published', 'description' => 'Visible', 'category' => 'Info', 'status' => 'published']);
        Blog::create(['title' => 'Draft Secret', 'description' => 'Hidden', 'category' => 'Info', 'status' => 'draft']);

        $this->get('/blog')->assertOk()->assertSee('Published')->assertDontSee('Draft Secret');
    }

    public function test_contact_form_stores_message_and_admin_can_read_it(): void
    {
        $this->post(route('contact.store'), [
            'name' => 'Pengunjung',
            'email' => 'visitor@example.com',
            'subject' => 'Informasi pendaftaran',
            'message' => 'Mohon informasi lebih lanjut.',
        ])->assertSessionHas('success');

        $message = ContactMessage::firstOrFail();
        $this->actingAs($this->admin())->get(route('admin.messages.show', $message))->assertOk();
        $this->assertNotNull($message->fresh()->read_at);
    }

    public function test_company_profile_is_managed_as_single_record(): void
    {
        $admin = $this->admin();
        $profile = CompanyProfile::create($this->profileData([
            'name' => 'Yayasan Lama',
            'is_active' => false,
        ]));

        $this->actingAs($admin)
            ->get(route('admin.profiles.index'))
            ->assertOk()
            ->assertSee('Yayasan Lama')
            ->assertDontSee('Tambah Profil');

        $this->actingAs($admin)
            ->put(route('admin.profiles.update'), $this->profileData(['name' => 'Yayasan Baru']))
            ->assertRedirect(route('admin.profiles.index'));

        $this->assertSame(1, CompanyProfile::count());
        $this->assertSame('Yayasan Baru', $profile->fresh()->name);
        $this->assertTrue($profile->fresh()->is_active);
    }

    public function test_company_profile_logo_can_be_replaced(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('profiles/logo-lama.png', 'old');

        $profile = CompanyProfile::create($this->profileData([
            'logo' => 'profiles/logo-lama.png',
            'is_active' => true,
        ]));

        $this->actingAs($this->admin())
            ->put(route('admin.profiles.update'), $this->profileData([
                'logo' => UploadedFile::fake()->image('logo-baru.png'),
            ]))
            ->assertRedirect(route('admin.profiles.index'));

        Storage::disk('public')->assertMissing('profiles/logo-lama.png');
        Storage::disk('public')->assertExists($profile->fresh()->logo);
    }

    public function test_company_profile_crud_routes_are_not_available(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin)->get('/admin/profiles/create')->assertNotFound();
        $this->actingAs($admin)->post('/admin/profiles', $this->profileData())->assertMethodNotAllowed();
        $this->actingAs($admin)->get('/admin/profiles/1')->assertNotFound();
        $this->actingAs($admin)->delete('/admin/profiles/1')->assertNotFound();
    }

    public function test_admin_can_export_article_pdf(): void
    {
        Blog::create(['title' => 'Laporan', 'description' => 'Isi', 'category' => 'Info', 'status' => 'published']);

        $this->actingAs($this->admin())->get(route('admin.articles.export-pdf'))
            ->assertOk()
            ->assertHeader('content-type', 'application/pdf');
    }

    public function test_all_public_pages_are_accessible(): void
    {
        foreach (['/', '/about', '/profile', '/blog', '/gallery', '/contact'] as $url) {
            $this->get($url)->assertOk();
        }
    }

    private function profileData(array $overrides = []): array
    {
        return array_merge([
            'name' => 'Yayasan Test',
            'summary' => 'Ringkasan',
            'description' => 'Deskripsi',
            'vision' => 'Visi',
            'mission' => 'Misi',
            'address' => 'Alamat',
            'phone' => '08123456789',
            'email' => 'info@example.com',
            'map_url' => 'https://maps.google.com',
        ], $overrides);
    }
}
