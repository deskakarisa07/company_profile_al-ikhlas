<?php

namespace Tests\Feature;

use App\Models\Blog;
use App\Models\CompanyProfile;
use App\Models\ContactMessage;
use App\Models\EducationUnit;
use App\Models\Gallery;
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
        $this->assertStringStartsWith('/storage/blogs/', $article->image_url);
    }

    public function test_admin_can_replace_and_delete_article_image(): void
    {
        Storage::fake('public');
        $admin = $this->admin();
        Storage::disk('public')->put('blogs/lama.png', 'old');
        $article = Blog::create([
            'title' => 'Artikel Lama',
            'category' => 'Kegiatan',
            'description' => 'Isi artikel.',
            'status' => 'published',
            'image' => 'blogs/lama.png',
        ]);

        $this->actingAs($admin)->put(route('admin.articles.update', $article), [
            'title' => 'Artikel Baru',
            'category' => 'Kegiatan',
            'description' => 'Isi artikel.',
            'status' => 'published',
            'image' => UploadedFile::fake()->image('baru.png'),
        ])->assertRedirect(route('admin.articles.index'));

        Storage::disk('public')->assertMissing('blogs/lama.png');
        Storage::disk('public')->assertExists($article->fresh()->image);

        $newImage = $article->fresh()->image;
        $this->actingAs($admin)
            ->delete(route('admin.articles.destroy', $article))
            ->assertSessionHas('success');

        Storage::disk('public')->assertMissing($newImage);
        $this->assertDatabaseMissing('blogs', ['id' => $article->id]);
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
        $this->assertStringStartsWith('/storage/profiles/', $profile->fresh()->logo_url);
    }

    public function test_admin_can_create_replace_and_delete_gallery_image(): void
    {
        Storage::fake('public');
        $admin = $this->admin();

        $this->actingAs($admin)->post(route('admin.galleries.store'), [
            'title' => 'Galeri Baru',
            'description' => 'Dokumentasi kegiatan.',
            'event_date' => '2026-06-21',
            'status' => 'published',
            'sort_order' => 1,
            'image' => UploadedFile::fake()->image('galeri.jpg'),
        ])->assertRedirect(route('admin.galleries.index'));

        $gallery = Gallery::where('title', 'Galeri Baru')->firstOrFail();
        $oldImage = $gallery->image;
        Storage::disk('public')->assertExists($oldImage);
        $this->assertStringStartsWith('/storage/galleries/', $gallery->image_url);

        $this->actingAs($admin)->put(route('admin.galleries.update', $gallery), [
            'title' => 'Galeri Diperbarui',
            'description' => 'Dokumentasi kegiatan.',
            'event_date' => '2026-06-21',
            'status' => 'published',
            'sort_order' => 1,
            'image' => UploadedFile::fake()->image('galeri-baru.png'),
        ])->assertRedirect(route('admin.galleries.index'));

        Storage::disk('public')->assertMissing($oldImage);
        Storage::disk('public')->assertExists($gallery->fresh()->image);

        $newImage = $gallery->fresh()->image;
        $this->actingAs($admin)
            ->delete(route('admin.galleries.destroy', $gallery))
            ->assertSessionHas('success');

        Storage::disk('public')->assertMissing($newImage);
        $this->assertDatabaseMissing('galleries', ['id' => $gallery->id]);
    }

    public function test_admin_can_create_replace_and_delete_education_unit_image(): void
    {
        Storage::fake('public');
        $admin = $this->admin();

        $this->actingAs($admin)->post(route('admin.units.store'), [
            'name' => 'SMA Al Ikhlas',
            'short_description' => 'Deskripsi singkat.',
            'description' => 'Deskripsi lengkap unit pendidikan.',
            'status' => 'published',
            'sort_order' => 4,
            'image' => UploadedFile::fake()->image('unit.jpg'),
        ])->assertRedirect(route('admin.units.index'));

        $unit = EducationUnit::where('name', 'SMA Al Ikhlas')->firstOrFail();
        $oldImage = $unit->image;
        Storage::disk('public')->assertExists($oldImage);
        $this->assertStringStartsWith('/storage/education-units/', $unit->image_url);

        $this->actingAs($admin)->put(route('admin.units.update', $unit), [
            'name' => 'SMA Al Ikhlas',
            'short_description' => 'Deskripsi singkat.',
            'description' => 'Deskripsi lengkap unit pendidikan.',
            'status' => 'published',
            'sort_order' => 4,
            'image' => UploadedFile::fake()->image('unit-baru.png'),
        ])->assertRedirect(route('admin.units.index'));

        Storage::disk('public')->assertMissing($oldImage);
        Storage::disk('public')->assertExists($unit->fresh()->image);

        $newImage = $unit->fresh()->image;
        $this->actingAs($admin)
            ->delete(route('admin.units.destroy', $unit))
            ->assertSessionHas('success');

        Storage::disk('public')->assertMissing($newImage);
        $this->assertDatabaseMissing('education_units', ['id' => $unit->id]);
    }

    public function test_seeded_public_images_keep_using_public_images_directory(): void
    {
        $blog = new Blog(['image' => 'blog1.png']);
        $unit = new EducationUnit(['image' => 'tk.png']);
        $profile = new CompanyProfile(['logo' => 'logo.png']);

        $this->assertStringEndsWith('/images/blog/blog1.png', $blog->image_url);
        $this->assertStringEndsWith('/images/tk.png', $unit->image_url);
        $this->assertStringEndsWith('/images/logo.png', $profile->logo_url);
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
