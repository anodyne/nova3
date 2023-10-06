<?php

switch ($_GET['type']) {
    case 'php':
        $message = 'php-version';
        break;

    case 'vendor-error':
        $message = 'vendor-error';
        break;

    case 'vendor-install':
        $message = 'vendor-install';
        break;
}

?><!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Nova 3 &bull; Important message</title>
		<script src="https://cdn.tailwindcss.com"></script>
	</head>
	<body class="font-sans text-slate-600 antialiased">
        <div class="relative isolate overflow-hidden bg-white">
            <svg class="absolute inset-0 -z-10 h-full w-full stroke-gray-200 [mask-image:radial-gradient(100%_100%_at_top_right,white,transparent)]" aria-hidden="true">
                <defs>
                    <pattern id="0787a7c5-978c-4f66-83c7-11c213f99cb7" width="200" height="200" x="50%" y="-1" patternUnits="userSpaceOnUse">
                        <path d="M.5 200V.5H200" fill="none" />
                    </pattern>
                </defs>
                <rect width="100%" height="100%" stroke-width="0" fill="url(#0787a7c5-978c-4f66-83c7-11c213f99cb7)" />
            </svg>
            <div class="mx-auto max-w-7xl px-6 pb-24 pt-10 sm:pb-32 lg:flex lg:px-8 lg:py-40">
                <div class="mx-auto max-w-2xl lg:mx-0 lg:max-w-xl lg:flex-shrink-0 lg:pt-8">
                    <svg viewBox="0 0 636 170" xmlns="http://www.w3.org/2000/svg" class="h-11"><g fill="none" fill-rule="evenodd"><path fill="#36384D" d="m297.649 145.332-76.732-68.974v68.974h-26.916V24.01h3.374l76.904 69.129V24.01h27.001v121.322zM366.142 48.864c-14.175 0-21.666 7.492-21.666 21.666v28.94c0 14.174 7.491 21.666 21.666 21.666h9.647c14.175 0 21.666-7.492 21.666-21.665V70.529c0-14.173-7.491-21.665-21.666-21.665h-9.647zm0 96.468c-30.86 0-45.863-15.001-45.863-45.861V70.529c0-30.861 15.002-45.863 45.863-45.863h9.647c30.86 0 45.862 15.001 45.862 45.864v28.94c0 30.86-15.002 45.862-45.862 45.862h-9.647zM483.241 145.332l-58.076-121.01h27.47l32.312 67.904 32.397-67.904h27.782l-58.299 121.01zM562.826 105.922h23.707L574.76 81.015l-11.934 24.907zm44.325 39.41-9.325-19.113h-46.295l-9.327 19.113H514.18l58.358-120.854h4.285l58.434 120.854h-28.105z"/><path d="M169.806 5.905 127.731 47.98c2.488 4.792 1.724 10.835-2.298 14.856-4.968 4.97-13.025 4.97-17.993 0-4.969-4.969-4.969-13.025 0-17.994 4.021-4.02 10.063-4.785 14.855-2.297L164.37.47 40.962 49.778l8.374 71.161 71.161 8.374 49.31-123.408z" fill="#A133FF"/><path d="m120.496 129.312-71.16-8.373 58.103-58.103c4.971 4.971 13.023 4.971 17.994 0 4.021-4.02 4.786-10.06 2.294-14.856l42.078-42.077-49.309 123.41z" fill="#33ADFF"/><path fill="#FF384F" d="m43.907 126.366 5.972 22.332L.744 169.53l20.832-49.135z"/><path fill="#FFA369" d="M49.88 148.7.746 169.528l43.162-43.163z"/></g></svg>

                    <?php include_once("nova/resources/messages/{$message}.php");?>
                </div>

                <div class="mx-auto mt-16 flex max-w-2xl sm:mt-24 lg:ml-10 lg:mr-0 lg:mt-0 lg:max-w-none lg:flex-none xl:ml-32">
                    <div class="max-w-3xl flex-none sm:max-w-5xl lg:max-w-none">
                        <div class="-m-2 rounded-xl bg-gray-900/5 p-2 ring-1 ring-inset ring-gray-900/10 lg:-m-4 lg:rounded-2xl lg:p-4">
                            <img src="https://tailwindui.com/img/component-images/project-app-screenshot.png" alt="App screenshot" width="2432" height="1442" class="w-[76rem] rounded-md shadow-2xl ring-1 ring-gray-900/10">
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</body>
</html>