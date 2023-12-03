<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>My Name Irvan Denata !</title>

  <!-- Fonts -->
  <link rel="dns-prefetch" href="//fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

  {{-- favicon --}}
  <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

  <!-- Scripts -->
  @vite(['resources/css/app.css', 'resources/js/app.js'])

  @stack('style')
</head>

<body class="w-full">

  <div id="spinner" class="w-full h-screen flex justify-center bg-background items-center fixed z-10 top-0 left-0">
    <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" class="animate-spin" height="1em"
      viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
      <path
        d="M304 48a48 48 0 1 0 -96 0 48 48 0 1 0 96 0zm0 416a48 48 0 1 0 -96 0 48 48 0 1 0 96 0zM48 304a48 48 0 1 0 0-96 48 48 0 1 0 0 96zm464-48a48 48 0 1 0 -96 0 48 48 0 1 0 96 0zM142.9 437A48 48 0 1 0 75 369.1 48 48 0 1 0 142.9 437zm0-294.2A48 48 0 1 0 75 75a48 48 0 1 0 67.9 67.9zM369.1 437A48 48 0 1 0 437 369.1 48 48 0 1 0 369.1 437z" />
    </svg>
  </div>

  <div class="snap-y container-fluid relative">

    @yield('content')
    <div class="snap-madatory snap-center container mb-4 mx-auto flex justify-center items-center" id="projects">
      <div class="w-full">
        <div class=" bg-background container rounded-lg border-2 border-gray p-4 dark:bg-gray-800 flex justify-center">
          <span class="text-sm text-gray-500 sm:text-center dark:text-gray-400">© 2023 <a href="#"
              class="hover:underline">Irvan Denata™</a>. All Rights Reserved.
          </span>
        </div>
      </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>


      function mouseEnter(element) {
        let parentId = element.target.parentElement.id
        let caption = document.querySelector('#' + parentId + ' .icon-caption')
        caption.classList.remove('invisible')
      }

      function mouseLeave(element) {
        let parentId = element.target.parentElement.id
        let caption = document.querySelector('#' + parentId + ' .icon-caption')
        caption.classList.add('invisible')
      }
      window.addEventListener("scroll", (event) => {
        let scroll = this.scrollY;
        let navigation = document.getElementById('navigation')
        if (scroll > 20) {
          navigation.classList.add('shadow')
        } else {
          navigation.classList.remove('shadow')
        }
      });

      function closeNav() {
        let menuMobile = document.querySelector('.mobile-menu');
        menuMobile.classList.add('hidden');
      }
      document.addEventListener('DOMContentLoaded', function() {
        setTimeout(() => {
          let spiner = document.getElementById('spinner')
          spiner.classList.add('hidden')
        }, 1000);

        var btnMenuMobile = document.getElementById('menu-button-mobile');
        var exitMenuMobile = document.getElementById('exit-menu-mobile');
        var menuMobile = document.querySelector('.mobile-menu');
        btnMenuMobile.addEventListener('click', function() {
          menuMobile.classList.remove('hidden');
        });
        exitMenuMobile.addEventListener('click', function() {
          menuMobile.classList.add('hidden');
        });

        var stackIcon = document.querySelectorAll('.icon-stack')
        var replacers = document.querySelectorAll('[data-replace]');
        for (var i = 0; i < replacers.length; i++) {
          let replaceClasses = JSON.parse(replacers[i].dataset.replace.replace(/'/g, '"'));
          Object.keys(replaceClasses).forEach(function(key) {
            replacers[i].classList.remove(key);
            replacers[i].classList.add(replaceClasses[key]);
          });
        }



        // var tooltip = document.querySelector('[data-tooltip-target]');
        // var tooltipTarget = document.getElementById(tooltip.dataset.tooltipTarget);
        // var tooltipPlacement = tooltip.dataset.tooltipPlacement;
        // var tooltipArrow = tooltip.querySelector('[data-popper-arrow]');
        // var tooltipInstance = createPopper(tooltip, tooltipTarget, {
        //     placement: tooltipPlacement,
        //     modifiers: [
        //         {
        //             name: 'offset',
        //             options: {
        //                 offset: [0, 8],
        //             },
        //         },
        //         {
        //             name: 'arrow',
        //             options: {
        //                 element: tooltipArrow,
        //             },
        //         },
        //     ],
        // });


      });
    </script>
    @stack('script')
</body>

</html>
