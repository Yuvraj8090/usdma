<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\NavbarItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\App;
use Stichoza\GoogleTranslate\GoogleTranslate;
use Exception;
use Illuminate\Support\Facades\Artisan;

class PageController extends Controller
{
    public function clearCache(Request $request)
{
    try {
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('route:clear');
        Artisan::call('view:clear');

        // Redirect back with success message
        return redirect()->back()->with('success', 'Cache, config, route, and view cleared successfully!');
    } catch (Exception $e) {
        // Redirect back with error message
        return redirect()->back()->withErrors('Failed to clear cache: ' . $e->getMessage());
    }
}

    // Show all pages
    public function listPages()
    {
        $pages = Page::latest()->paginate(10);
        return view('admin.pages.index', compact('pages'));
    }

    // Show create form
    public function showCreateForm()
    {
        return view('admin.pages.create');
    }

    // Store new page
   public function createPage(Request $request)
{
    try {
        $validated = $request->validate([
            'title'            => 'required|string|max:255',
            'title_hi'         => 'nullable|string|max:255',
            'body_eng'         => 'required|string',
            'body_hindi'       => 'required|string',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords'    => 'nullable|string',
        ]);

        $validated['slug'] = Page::createSlug($validated['title']);
        $validated['status'] = 0; // default to 0
        Page::create($validated);

        return redirect()->route('admin.pages.list')->with('success', 'Page created successfully.');
    } catch (Exception $e) {
        Log::error('Error creating page: ' . $e->getMessage());
        return back()->withErrors($e->getMessage())->withInput();
    }
}


    // Show edit form
    public function showEditForm($id)
    {
        $page = Page::findOrFail($id);
        return view('admin.pages.edit', compact('page'));
    }
private function validatePageRequest(Request $request, $id = null)
{
    return $request->validate([
        'title'            => 'required|string|max:255',
        'title_hi'         => 'nullable|string|max:255',
        'slug'             => 'sometimes|string|max:255|unique:pages,slug,' . $id,
        'body_eng'         => 'required|string',
        'body_hindi'       => 'required|string',
        'meta_title'       => 'nullable|string|max:255',
        'meta_description' => 'nullable|string',
        'meta_keywords'    => 'nullable|string',
    ]);
}

    // Update page
   public function updatePage(Request $request, $id)
    {
        try {
            $page = Page::findOrFail($id);

            $validated = $this->validatePageRequest($request, $page->id);

            $validated['status'] = $request->input('status') == '1' ? 1 : 0;

            $page->update($validated);

            // Sync active status with related navbar item
            NavbarItem::where('slug', $validated['slug'])->update([
                'is_active' => $validated['status'],
            ]);

            return redirect()->route('admin.pages.list')->with('success', 'Page and navigation updated successfully.');
        } catch (Exception $e) {
            Log::error('Error updating page: ' . $e->getMessage());
            return back()->withErrors('An unexpected error occurred.')->withInput();
        }
    }

    // Delete page
    public function deletePage($id)
    {
        try {
            $page = Page::findOrFail($id);
            $page->delete();
            return redirect()->route('admin.pages.list')->with('success', 'Page deleted successfully.');
        } catch (Exception $e) {
            Log::error('Error deleting page: ' . $e->getMessage());
            return redirect()->route('admin.pages.list')->withErrors('Failed to delete the page.');
        }
    }

    // Show a page by slug
    public function showPage($slug)
    {
        $page = Page::where('slug', $slug)
                    ->where('status', 1)
                    ->firstOrFail();

        $navbarItem = NavbarItem::where('slug', $slug)->first();

        $sidebarItems = collect();
        if ($navbarItem) {
            $parentId = $navbarItem->parent_id ?? $navbarItem->id;

            $sidebarItems = NavbarItem::where('parent_id', $parentId)
                ->where('is_active', 1)
                ->orderBy('order')
                ->get();
        }

        $breadcrumbs = $navbarItem ? $this->getBreadcrumbs($navbarItem) : [];
        $body = $page->body_eng;
       

        return view('pages.show', compact('page', 'body', 'sidebarItems', 'breadcrumbs'));
    }
    protected function getTranslatedBreadcrumbs($navbarItem, $translator)
    {
        $breadcrumbs = [];
    
        while ($navbarItem) {
            array_unshift($breadcrumbs, [
                'title' => $translator->translate($navbarItem->title),
                'slug'  => $navbarItem->slug,
            ]);
    
            $navbarItem = $navbarItem->parent; // Assuming parent() relationship
        }
    
        return $breadcrumbs;
    }
    

public function showPageHi($slug)
{
    // Set the application locale to Hindi
    App::setLocale('hi');

    // Translator instance for Hindi
    $translator = new GoogleTranslate('hi');

    // Fetch the active page by slug
    $page = Page::where('slug', $slug)
                ->where('status', 1)
                ->firstOrFail();

    // Translate or use existing Hindi content
    $body = $page->body_hindi ?: $translator->translate($page->body);
$pageTitleHI =$page->title_hi;
    // Fetch the matching navbar item
    $navbarItem = NavbarItem::where('slug', $slug)->first();

    // Initialize sidebar items
    $sidebarItems = collect();

    if ($navbarItem) {
        $parentId = $navbarItem->parent_id ?? $navbarItem->id;

        $sidebarItems = NavbarItem::where('parent_id', $parentId)
            ->where('is_active', 1)
            ->orderBy('order')
            ->get()
            ->map(function ($item) use ($translator) {
                $item->translated_title = $item->title_hi ?: $translator->translate($item->title);
                return $item;
            });
    }

    // Breadcrumb translation
    $breadcrumbs = $navbarItem ? $this->getTranslatedBreadcrumbs($navbarItem, $translator) : [];

    // Return the page view
    return view('pages.show', [
        'page'         => $page,
        'pageTitleHI'=> $pageTitleHI,
        'body'         => $body,
        'sidebarItems' => $sidebarItems,
        'breadcrumbs'  => $breadcrumbs,
        'lang'         => 'hi',
    ]);
}

    

    // Helper for breadcrumbs
    private function getBreadcrumbs($navbarItem)
    {
        $breadcrumbs = [];

        while ($navbarItem) {
            $breadcrumbs[] = $navbarItem;
            $navbarItem = $navbarItem->parent;
        }

        return array_reverse($breadcrumbs);
    }
public function showLocalizedPage($lang, $slug)
{
    App::setLocale($lang);

    // 1. Fetch the page and check if it's active
    $page = Page::where('slug', $slug)
                ->where('status', 1)
                ->firstOrFail();

    // 2. Determine content language
    $locale = $lang === 'hi' ? 'hi' : 'en';
    $translator = $locale === 'hi' ? new GoogleTranslate('hi') : null;

    // 3. Choose correct body content
    $body = $locale === 'hi'
        ? ($page->body_hindi ?: ($translator ? $translator->translate($page->body_eng) : $page->body_eng))
        : $page->body_eng;

    // 4. Fetch related navbar item
    $navbarItem = NavbarItem::where('slug', $slug)->first();

    $sidebarItems = collect();
    if ($navbarItem) {
        $parentId = $navbarItem->parent_id ?? $navbarItem->id;

        $sidebarItems = NavbarItem::where('parent_id', $parentId)
            ->where('is_active', 1)
            ->orderBy('order')
            ->get()
            ->map(function ($item) use ($locale, $translator) {
                $item->translated_title = $locale === 'hi' && $translator
                    ? $translator->translate($item->title)
                    : $item->title;
                return $item;
            });
    }

    // 5. Get breadcrumbs with smart check on Page existence
    $breadcrumbs = [];

    if ($navbarItem) {
        $rawBreadcrumbs = $locale === 'hi' && $translator
            ? $this->getTranslatedBreadcrumbs($navbarItem, $translator)
            : $this->getBreadcrumbs($navbarItem);

        foreach ($rawBreadcrumbs as $breadcrumb) {
            $breadcrumbSlug = $locale === 'hi'
                ? ($breadcrumb['slug_hi'] ?? $breadcrumb['slug'])
                : $breadcrumb['slug'];

            // Check if Page exists
            $pageExists = Page::where('slug', $breadcrumbSlug)->where('status', 1)->exists();

            $breadcrumbs[] = [
                'title' => $locale === 'hi'
                    ? ($breadcrumb['title_hi'] ?? $breadcrumb['title'])
                    : $breadcrumb['title'],
                'slug' => $pageExists ? $breadcrumbSlug : null, // Only provide slug if Page exists
            ];
        }
    }

    return view('pages.show', [
        'page'         => $page,
        'body'         => $body,
        'sidebarItems' => $sidebarItems,
        'breadcrumbs'  => $breadcrumbs,
        'lang'         => $locale,
    ]);
}

public function showWelcomePage($lang = 'en')
{
    App::setLocale($lang);
    $translator = $lang === 'hi' ? new GoogleTranslate('hi') : null;

    $title = $lang === 'hi' && $translator ? $translator->translate('Welcome to our site!') : 'Welcome to our site!';
    $description = $lang === 'hi' && $translator ? $translator->translate('This is our homepage.') : 'This is our homepage.';

    return view('welcome', compact('title', 'description', 'lang'));
}
}