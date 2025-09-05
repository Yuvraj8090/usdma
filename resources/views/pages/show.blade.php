  
 @php
    $locale = app()->getLocale();
    $localePrefix = $locale === 'hi' ? 'hi' : 'en';
    $currentSlug = request()->segment(2) ?? request()->segment(1);
    $pageTitle = $page->translated_title ?? $page->title ?? ($locale === 'hi' ? 'होम' : 'Home');

    // For JS
    $snoLabel = $locale === 'hi' ? 'क्रम संख्या' : 'S.No.';
    $useHindiNumbers = $locale === 'hi';
    function getLocalizedTitle($item, $locale) {
            if ($locale === 'hi') {
                return $item->title_hi ?? $item->translated_title ?? $item->title ?? '';
            }
            return $item->translated_title ?? $item->title ?? '';
        }
@endphp

<script>
  const snoLabel = @json($snoLabel);
  const useHindiNumbers = @json($useHindiNumbers);
</script>
<x-guest-layout>
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="no-js">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ allsettings('site.description') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ allsettings('site.title') }} - {{ $pageTitle }}</title>
    

    <style>
        :root {
            --primary-color: #1d4ed8;
            --primary-hover: #1e40af;
            --sidebar-width: 16rem;
            --sidebar-collapsed-width: 4rem;
        }
        
        main .active-link {
            font-weight: 600;
            color: var(--primary-hover);
        }
        
        main h1, h2, h3, h4, h5, h6 {
            font-weight: 700 !important;
        }
        
        main .prose {
            color: #000 !important;
        }
        
       
        main th {
            padding: 1rem !important;
            background: #333 !important;
            color: white !important;
        }
        
        main section a {
            text-decoration: underline !important;
            color: var(--primary-color) !important;
        }
        
        main thead {
            background-color: #f3f4f6;
            color: #374151;
            text-transform: uppercase;
            font-size: .875rem;
        }
        
        main thead th {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #d1d5db;
        }
        
        main section li {
            list-style-type: decimal !important;
        }
        
        main td a {
            display: flex !important;
            width: max-content !important;
        }
        
        main tbody {
            color: #374151;
        }
        
        main tbody tr:hover {
            background-color: #f9fafb;
        }
        
        main tbody td {
            padding: 1rem;
            border-bottom: 1px solid #d1d5db;
        }
        
        /* Sidebar toggle styles */
        .sidebar-toggle {
            transition: all 0.3s ease;
        }
        
        .sidebar-collapsed {
            width: var(--sidebar-collapsed-width);
            overflow: hidden;
        }
        
        .sidebar-collapsed .nav-item-text {
            display: none;
        }
        
        .sidebar-collapsed .nav-item-icon {
            margin-right: 0;
        }
        
        .sidebar-expanded {
            width: var(--sidebar-width);
        }
        
        @media (max-width: 768px) {
            .sidebar-container {
                position: fixed;
                z-index: 1000;
                height: 100vh;
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }
            
            .sidebar-open {
                transform: translateX(0);
            }
            
            .sidebar-overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: rgba(0,0,0,0.5);
                z-index: 999;
            }
            
            .sidebar-overlay.active {
                display: block;
            }
        }
    </style>
    <script>
  document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll("table").forEach(function (table) {
      const thead = table.querySelector("thead");
      const tbody = table.querySelector("tbody");

      if (thead && tbody) {
        // Tailwind styling
        table.classList.add(
          "table-auto",
          "min-w-full",
          "bg-white",
          "shadow-md",
          "rounded-lg",
          "overflow-hidden"
        );

        // Add "S.No." or "क्रम संख्या"
        const headRow = thead.querySelector("tr");
        if (headRow) {
          const snoTh = document.createElement("th");
          snoTh.textContent = snoLabel;
          snoTh.className = "px-4 py-2 text-left";
          headRow.insertBefore(snoTh, headRow.firstChild);
        }

        // Function to convert number to Hindi numerals
        function toHindiNumerals(num) {
          return String(num).replace(/\d/g, d => "०१२३४५६७८९"[d]);
        }

        // Add serial numbers (in correct numeral set)
        Array.from(tbody.querySelectorAll("tr")).forEach((row, index) => {
          const snoTd = document.createElement("td");
          const displayNumber = useHindiNumbers ? toHindiNumerals(index + 1) : index + 1;
          snoTd.textContent = displayNumber;
          snoTd.className = "px-4 py-2";
          row.insertBefore(snoTd, row.firstChild);
        });

        // Wrap in containers
        const overflowDiv = document.createElement("div");
        overflowDiv.className = "overflow-x-auto";

        const containerDiv = document.createElement("div");
        containerDiv.className = "container mx-auto";

        table.parentNode.insertBefore(containerDiv, table);
        containerDiv.appendChild(overflowDiv);
        overflowDiv.appendChild(table);
      }
    });
  });
</script>

</head>
<body class="bg-gray-50 text-gray-800">
   
  

    <div class="flex flex-col md:flex-row min-h-screen relative">
        <!-- Mobile sidebar toggle button -->
        <button id="sidebarToggle" class="md:hidden fixed bottom-4 left-4 z-50 bg-blue-600 text-white p-3 rounded-full shadow-lg">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
        
        <!-- Sidebar overlay for mobile -->
        <div id="sidebarOverlay" class="sidebar-overlay"></div>
        
        <!-- Sidebar -->
        <aside id="sidebar" class="sidebar-container w-full md:w-64 bg-white shadow-lg border-r p-4 md:p-6 transition-all duration-300">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-semibold text-gray-800">{{ $locale === 'hi' ? 'मेनू' : 'Menu' }}</h3>
                <button id="closeSidebar" class="md:hidden text-gray-500 hover:text-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
             <ul class="space-y-2">
       
            
            
        </ul>
            @if(count($sidebarItems) > 0)
            <ul class="space-y-2">
                @foreach($sidebarItems as $item)
                @php
                $itemSlug = $locale === 'hi' ? ($item->slug_hi ?? $item->slug) : $item->slug;
                $itemTitle = $item->translated_title ?? $item->title;
                $url = url($localePrefix . '/' . $itemSlug);
                $isActive = $itemSlug === $currentSlug;
            @endphp
                <li class="nav-item">
                    <a href="{{ $url }}" class="flex items-center px-4 py-2 rounded-lg capitalize transition-all duration-200 {{ $isActive ? 'bg-blue-100 text-blue-700 font-semibold' : 'text-gray-700 hover:bg-blue-50 hover:text-blue-600' }}">
                        <span class="nav-item-icon mr-3">
                            <i class="{{ $item->icon ?? 'fas fa-circle' }} text-sm"></i>
                        </span>
                        <span class="nav-item-text">{{ $itemTitle }}</span>
                    </a>
                    
                   
                </li>
                @endforeach
            </ul>
            @else
            <div class="text-center py-8 text-gray-500">
               
            </div>
            @endif
            
            <!-- Collapse/Expand button for desktop -->
            
        </aside>

        <main class="flex-1 p-4 md:p-10">
            <!-- Breadcrumbs -->
            <nav class="text-sm text-gray-600 mb-6" aria-label="Breadcrumb">
                <ol class="flex flex-wrap items-center space-x-2">
                    <li class="flex items-center">
                        <a href="{{ url($localePrefix . '/') }}" class="text-gray-600 hover:text-blue-600 capitalize">
                            {{ $locale === 'hi' ? 'होम' : 'Home' }}
                        </a>
                        @if(!empty($breadcrumbs))
                            <svg class="mx-2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        @endif
                    </li>

                    @if(!empty($breadcrumbs))
                        @foreach($breadcrumbs as $breadcrumb)
                            @php
                                $breadcrumbSlug = $locale === 'hi' ? ($breadcrumb['slug_hi'] ?? $breadcrumb['slug']) : $breadcrumb['slug'];
                                $breadcrumbTitle = $locale === 'hi' ? ($breadcrumb['title_hi'] ?? $breadcrumb['title']) : $breadcrumb['title'];
                                $breadcrumbUrl = url($localePrefix . '/' . $breadcrumbSlug);
                                $isCurrent = $loop->last;
                            @endphp
                            <li class="flex items-center">
                                @if(!$isCurrent)
                                    <a href="{{ $breadcrumbUrl }}" class="capitalize text-gray-600 hover:text-blue-600">
                                        {{ $breadcrumbTitle }}
                                    </a>
                                    <svg class="mx-2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                @else
                                    <span class="active-link capitalize" aria-current="page">{{ $breadcrumbTitle }}</span>
                                @endif
                            </li>
                        @endforeach
                    @else
                        <li class="flex items-center">
                            <span class="active-link capitalize" aria-current="page">
    {{ $localePrefix === 'hi' ? $page->title_hi : $page->title }}
</span>
                        </li>
                    @endif
                </ol>
            </nav>

            <!-- Main Content -->
            <section class="prose prose-lg max-w-none bg-white p-4 md:p-8 rounded-xl shadow-md prose-headings:text-gray-800 prose-p:text-gray-700 prose-li:list-disc">
                {!! $body !!}
            </section>
        </main>
    </div>

    <!-- Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile sidebar toggle
            const sidebar = document.getElementById('sidebar');
            const sidebarToggle = document.getElementById('sidebarToggle');
            const closeSidebar = document.getElementById('closeSidebar');
            const sidebarOverlay = document.getElementById('sidebarOverlay');
            
            // Desktop sidebar toggle
            const toggleSidebar = document.getElementById('toggleSidebar');
            let isSidebarCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
            
            // Initialize sidebar state
            function initSidebar() {
                if (window.innerWidth >= 768) {
                    if (isSidebarCollapsed) {
                        sidebar.classList.add('sidebar-collapsed');
                        sidebar.classList.remove('sidebar-expanded');
                        toggleSidebar.querySelector('svg').classList.add('rotate-180');
                    } else {
                        sidebar.classList.add('sidebar-expanded');
                        sidebar.classList.remove('sidebar-collapsed');
                        toggleSidebar.querySelector('svg').classList.remove('rotate-180');
                    }
                }
            }
            
            // Toggle mobile sidebar
            sidebarToggle.addEventListener('click', () => {
                sidebar.classList.add('sidebar-open');
                sidebarOverlay.classList.add('active');
            });
            
            closeSidebar.addEventListener('click', () => {
                sidebar.classList.remove('sidebar-open');
                sidebarOverlay.classList.remove('active');
            });
            
            sidebarOverlay.addEventListener('click', () => {
                sidebar.classList.remove('sidebar-open');
                sidebarOverlay.classList.remove('active');
            });
            
            // Toggle desktop sidebar
            if (toggleSidebar) {
                toggleSidebar.addEventListener('click', () => {
                    isSidebarCollapsed = !isSidebarCollapsed;
                    localStorage.setItem('sidebarCollapsed', isSidebarCollapsed);
                    
                    if (isSidebarCollapsed) {
                        sidebar.classList.add('sidebar-collapsed');
                        sidebar.classList.remove('sidebar-expanded');
                        toggleSidebar.querySelector('svg').classList.add('rotate-180');
                    } else {
                        sidebar.classList.add('sidebar-expanded');
                        sidebar.classList.remove('sidebar-collapsed');
                        toggleSidebar.querySelector('svg').classList.remove('rotate-180');
                    }
                });
            }
            
            // Initialize on load
            initSidebar();
            
            // Handle window resize
            window.addEventListener('resize', () => {
                if (window.innerWidth >= 768) {
                    sidebar.classList.remove('sidebar-open');
                    sidebarOverlay.classList.remove('active');
                    initSidebar();
                }
            });
            
            // Close sidebar when clicking a link (for mobile)
            document.querySelectorAll('#sidebar a').forEach(link => {
                link.addEventListener('click', () => {
                    if (window.innerWidth < 768) {
                        sidebar.classList.remove('sidebar-open');
                        sidebarOverlay.classList.remove('active');
                    }
                });
            });
        });
    </script>
    
  
</body>
</html>
</x-guest-layout>