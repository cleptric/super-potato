<header class="bg-white shadow-sm">
    <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
        <h1 class="text-lg leading-6 font-semibold text-gray-900">
            Wien-Schwechat (LOWW)
        </h1>
    </div>
</header>
<main>
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <dl class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-5">
            <div class="px-4 py-5 bg-white shadow rounded-lg overflow-hidden sm:p-6">
                <dt class="text-sm font-medium text-gray-500 truncate">
                    ATIS Information
                </dt>
                <dd class="mt-1 text-3xl font-semibold text-gray-900">
                    <?= $atis['atis_letter'] ?>
                </dd>
            </div>

            <div class="px-4 py-5 bg-white shadow rounded-lg overflow-hidden sm:p-6">
                <dt class="text-sm font-medium text-gray-500 truncate">
                    Transition Level
                </dt>
                <dd class="mt-1 text-3xl font-semibold text-gray-900">
                    FL <?= $atis['transition_level'] ?>
                </dd>
            </div>

            <div class="px-4 py-5 bg-white shadow rounded-lg overflow-hidden sm:p-6">
                <dt class="text-sm font-medium text-gray-500 truncate">
                    QNH
                </dt>
                <dd class="mt-1 text-3xl font-semibold text-gray-900">
                    <?= $metarDecoder->getPressure()->getValue() ?>
                    <span class="text-lg font-medium text-gray-500"><?= $metarDecoder->getPressure()->getUnit() ?></span>
                </dd>
            </div>

            <div class="px-4 py-5 bg-white shadow rounded-lg overflow-hidden sm:p-6">
                <dt class="text-sm font-medium text-gray-500 truncate">
                    Date
                </dt>
                <dd class="mt-1 text-3xl font-semibold text-gray-900">
                    <?= date('d.m.Y') ?>
                </dd>
            </div>

            <div class="px-4 py-5 bg-white shadow rounded-lg overflow-hidden sm:p-6">
                <dt class="text-sm font-medium text-gray-500 truncate">
                    Time
                </dt>
                <dd class="mt-1 text-3xl font-semibold text-gray-900">
                    <?= date('H:i:s') ?>
                </dd>
            </div>
        </dl>
    </div>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <dl class="grid grid-cols-1 gap-5">
            <div class="px-4 py-5 bg-white shadow rounded-lg overflow-hidden sm:p-6">
                <dt class="text-sm font-medium text-gray-500 truncate">
                    METAR
                </dt>
                <dd class="mt-1 text-2xl font-semibold text-gray-900">
                    <?= $metarDecoder->getRawMetar() ?>
                </dd>
            </div>
        </dl>
    </div>

    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="relative h-[720px] px-4 py-5 bg-white shadow rounded-lg overflow-hidden sm:p-6">
            <dl class="absolute mt-5 grid grid-cols-1 gap-5 lg:grid-cols-2" style="right: 2rem; top: 2rem;">
                <div class="relative min-w-[280px] bg-white pt-5 px-4 pb-5 sm:pt-6 sm:px-6 shadow rounded-lg overflow-hidden">
                    <dt>
                        <div class="absolute bg-blue-500 rounded-md p-3">
                            <!-- Font Awesome name: far/clouds -->
                            <svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="clouds" class="h-6 w-6 text-white svg-inline--fa fa-clouds fa-w-20" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
                                <path fill="currentColor" d="M538.7 296.2C525.2 253.8 486 224 440 224c-13.5 0-26.8 2.6-39.2 7.7-1.8-2.1-4.1-3.6-6-5.5 17-19 26.5-43.6 26.5-68.9 0-57.3-46.7-104-104-104-7 0-13.9.7-20.7 2.1C275.5 21.6 238 0 197.3 0c-51.2 0-96 33.9-111.3 81.6C37.2 90.1 0 132.8 0 184c0 57.3 46.7 104 104 104h90.8c-1.2 5.7-2.3 11.4-2.7 17.4-38.6 17-64.2 55.1-64.2 98.6 0 59.5 48.4 108 108 108h296c59.6 0 108-48.5 108-108 .1-57.3-44.8-104.3-101.2-107.8zM104 240c-30.9 0-56-25.1-56-56 0-30.4 24.4-55.3 54.7-56l23.4.8 3-21.3c4.8-33.9 34.2-59.5 68.2-59.5 29 0 54.3 17.7 64.6 45l9 24 23.3-10.6c7.5-3.4 15.2-5.1 23-5.1 30.9 0 56 25.1 56 56 0 15.8-6.7 30.5-18.8 41.4l-1.3 1.2c-13-4.8-26.8-7.9-41.3-7.9-39.1 0-73.8 18.9-95.7 48H104zm428 224H236c-33.1 0-60-26.9-60-60 0-28 19.1-52 46.4-58.3l20.8-4.8-2.8-24.9c-.2-1.3-.4-2.6-.4-4 0-39.7 32.3-72 72-72 25.2 0 48.2 13.1 61.4 35.1l13.3 22.1 21.1-14.9c9.6-6.8 20.7-10.3 32.2-10.3 28.6 0 52.4 21.7 55.3 50.4l2.2 21.6H532c33.1 0 60 26.9 60 60s-26.9 60-60 60z">
                                </path>
                            </svg>
                        </div>
                        <p class="ml-16 text-sm font-medium text-gray-500 truncate">
                            Visiblity
                        </p>
                    </dt>
                    <dd class="ml-16 flex items-baseline">
                        <p class="text-2xl font-semibold text-gray-900">
                            VMC
                        </p>
                    </dd>
                </div>
                <div class="relative min-w-[280px] bg-white pt-5 px-4 pb-5 sm:pt-6 sm:px-6 shadow rounded-lg overflow-hidden">
                    <dt>
                        <div class="absolute bg-blue-500 rounded-md p-3">
                            <!-- Font Awesome name: far/windsock -->
                            <svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="windsock" class="h-6 w-6 text-white svg-inline--fa fa-windsock fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                <path fill="currentColor" d="M484.2 148.3l-389.9-52C105.1 86.2 112 72 112 56c0-30.9-25.1-56-56-56S0 25.1 0 56c0 22.3 13.1 41.4 32 50.4V496c0 8.8 7.2 16 16 16h16c8.8 0 16-7.2 16-16V369.6l404.2-53.9C500.1 313.6 512 300 512 284V180c0-16-11.9-29.6-27.8-31.7zM320 174.8v114.3L224 302V162l96 12.8zm-240-32l80 10.7v157l-80 10.7V142.8zM464 270l-80 10.7v-97.3l80 10.7V270z"></path>
                            </svg>
                        </div>
                        <p class="ml-16 text-sm font-medium text-gray-500 truncate">
                            Surface Wind
                        </p>
                    </dt>
                    <dd class="ml-16 flex items-baseline">
                        <p class="text-2xl font-semibold text-gray-900">
                            <?= $metarDecoder->getSurfaceWind()->getMeanDirection()->getValue(); ?> / <?= $metarDecoder->getSurfaceWind()->getMeanSpeed()->getValue(); ?>
                            <!-- <?= $metarDecoder->getSurfaceWind()->getSpeedVariations()?->getValue(); ?> -->
                        </p>
                    </dd>
                </div>
            </dl>

            <div class="absolute w-[120px] h-[550px] flex flex-col justify-between border border-gray-200 rounded-lg transform -rotate-40" style="left: 220px; top: 40px;">
                <div class="relative x-4 py-5 text-center text-2xl font-black">
                    <div class="absolute flex items-center text-yellow-400 text-md font-medium transform rotate-40" style="top: 50px; right: -80px;">
                        <!-- Font Awesome name: far/location-circle -->
                        <svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="location-circle" class="h-6 w-6 svg-inline--fa fa-location-circle fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 512" style="transform: rotate(45deg);">
                            <path fill="currentColor" d="M304.51 140.2l-182.06 83.66c-19.85 9.23-30.01 29.64-25.32 50.81 4.63 20.69 22.67 35.15 43.89 35.15h52.99v52.73c0 21.14 14.54 39.1 35.32 43.69 3.44.76 6.88 1.14 10.25 1.14 17.38 0 33.01-9.82 40.8-26.45l84-181.13.38-.83c6.94-16.57 2.94-35.75-10.22-48.87-13.23-13.15-32.49-17.15-50.03-9.9zm-62.49 209.41v-87.58h-88.06l163.53-75.15-75.47 162.73zM248 8C111.03 8 0 119.03 0 256s111.03 248 248 248 248-111.03 248-248S384.97 8 248 8zm0 448c-110.28 0-200-89.72-200-200S137.72 56 248 56s200 89.72 200 200-89.72 200-200 200z">
                            </path>
                        </svg>
                        <span class="ml-1">12 C</span>
                    </div>
                    34
                </div>
                <div class="relative bg-blue-200 px-4 py-5 text-center text-2xl font-black rounded-lg">
                    <div class="absolute h-6 w-6" style="bottom: -40px; right: 50%; transform: translateX(50%);">
                        <!-- Font Awesome name: far/arrow-to-top -->
                        <svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="arrow-to-top" class="svg-inline--fa fa-arrow-to-top fa-w-12" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
                            <path fill="currentColor" d="M35.5 279.9l148-148.4c4.7-4.7 12.3-4.7 17 0l148 148.4c4.7 4.7 4.7 12.3 0 17l-19.6 19.6c-4.8 4.8-12.5 4.7-17.1-.2L218 219.2V468c0 6.6-5.4 12-12 12h-28c-6.6 0-12-5.4-12-12V219.2l-93.7 97.1c-4.7 4.8-12.4 4.9-17.1.2l-19.6-19.6c-4.8-4.7-4.8-12.3-.1-17zM12 84h360c6.6 0 12-5.4 12-12V44c0-6.6-5.4-12-12-12H12C5.4 32 0 37.4 0 44v28c0 6.6 5.4 12 12 12z"></path>
                        </svg>
                    </div>
                    <div class="absolute h-6 w-6" style="top: -40px; right: 50%; transform: translateX(50%);">
                        <!-- Font Awesome name: far/arrow-up -->
                        <svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="arrow-up" class="svg-inline--fa fa-arrow-up fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                            <path fill="currentColor" d="M6.101 261.899L25.9 281.698c4.686 4.686 12.284 4.686 16.971 0L198 126.568V468c0 6.627 5.373 12 12 12h28c6.627 0 12-5.373 12-12V126.568l155.13 155.13c4.686 4.686 12.284 4.686 16.971 0l19.799-19.799c4.686-4.686 4.686-12.284 0-16.971L232.485 35.515c-4.686-4.686-12.284-4.686-16.971 0L6.101 244.929c-4.687 4.686-4.687 12.284 0 16.97z"></path>
                        </svg>
                    </div>
                    <div class="absolute flex items-center text-yellow-400 text-md font-medium transform rotate-40" style="top: 10px; left: -80px;">
                        <!-- Font Awesome name: far/location-circle -->
                        <svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="location-circle" class="h-6 w-6 svg-inline--fa fa-location-circle fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 512" style="transform: rotate(45deg);">
                            <path fill="currentColor" d="M304.51 140.2l-182.06 83.66c-19.85 9.23-30.01 29.64-25.32 50.81 4.63 20.69 22.67 35.15 43.89 35.15h52.99v52.73c0 21.14 14.54 39.1 35.32 43.69 3.44.76 6.88 1.14 10.25 1.14 17.38 0 33.01-9.82 40.8-26.45l84-181.13.38-.83c6.94-16.57 2.94-35.75-10.22-48.87-13.23-13.15-32.49-17.15-50.03-9.9zm-62.49 209.41v-87.58h-88.06l163.53-75.15-75.47 162.73zM248 8C111.03 8 0 119.03 0 256s111.03 248 248 248 248-111.03 248-248S384.97 8 248 8zm0 448c-110.28 0-200-89.72-200-200S137.72 56 248 56s200 89.72 200 200-89.72 200-200 200z">
                            </path>
                        </svg>
                        <span class="ml-1">12 C</span>
                    </div>
                    16
                </div>
            </div>
            <div class="absolute w-[120px] h-[550px] flex flex-col justify-between border border-gray-200 rounded-lg transform -rotate-90" style="right: 300px; bottom: 0px;">
                <div class="relative px-4 py-5 text-center text-2xl font-black">
                    <div class="absolute flex items-center text-green-400 text-md font-medium transform rotate-90" style="top: 20px; right: -60px;">
                        <!-- Font Awesome name: far/location-circle -->
                        <svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="location-circle" class="h-6 w-6 svg-inline--fa fa-location-circle fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 512" style="transform: rotate(45deg);">
                            <path fill="currentColor" d="M304.51 140.2l-182.06 83.66c-19.85 9.23-30.01 29.64-25.32 50.81 4.63 20.69 22.67 35.15 43.89 35.15h52.99v52.73c0 21.14 14.54 39.1 35.32 43.69 3.44.76 6.88 1.14 10.25 1.14 17.38 0 33.01-9.82 40.8-26.45l84-181.13.38-.83c6.94-16.57 2.94-35.75-10.22-48.87-13.23-13.15-32.49-17.15-50.03-9.9zm-62.49 209.41v-87.58h-88.06l163.53-75.15-75.47 162.73zM248 8C111.03 8 0 119.03 0 256s111.03 248 248 248 248-111.03 248-248S384.97 8 248 8zm0 448c-110.28 0-200-89.72-200-200S137.72 56 248 56s200 89.72 200 200-89.72 200-200 200z">
                            </path>
                        </svg>
                        <span class="ml-1">0 T</span>
                    </div>
                    29
                </div>
                <div class="relative bg-blue-200 px-4 py-5 text-center text-2xl font-black rounded-lg">
                    <div class="absolute h-6 w-6" style="bottom: -40px; right: 50%; transform: translateX(50%);">
                        <!-- Font Awesome name: far/arrow-to-top -->
                        <svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="arrow-to-top" class="svg-inline--fa fa-arrow-to-top fa-w-12" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
                            <path fill="currentColor" d="M35.5 279.9l148-148.4c4.7-4.7 12.3-4.7 17 0l148 148.4c4.7 4.7 4.7 12.3 0 17l-19.6 19.6c-4.8 4.8-12.5 4.7-17.1-.2L218 219.2V468c0 6.6-5.4 12-12 12h-28c-6.6 0-12-5.4-12-12V219.2l-93.7 97.1c-4.7 4.8-12.4 4.9-17.1.2l-19.6-19.6c-4.8-4.7-4.8-12.3-.1-17zM12 84h360c6.6 0 12-5.4 12-12V44c0-6.6-5.4-12-12-12H12C5.4 32 0 37.4 0 44v28c0 6.6 5.4 12 12 12z"></path>
                        </svg>
                    </div>
                    <div class="absolute flex items-center text-red-400 text-md font-medium transform rotate-90" style="top: 20px; right: -60px;">
                        <!-- Font Awesome name: far/location-circle -->
                        <svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="location-circle" class="h-6 w-6 svg-inline--fa fa-location-circle fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 512" style="transform: rotate(-135deg);">
                            <path fill="currentColor" d="M304.51 140.2l-182.06 83.66c-19.85 9.23-30.01 29.64-25.32 50.81 4.63 20.69 22.67 35.15 43.89 35.15h52.99v52.73c0 21.14 14.54 39.1 35.32 43.69 3.44.76 6.88 1.14 10.25 1.14 17.38 0 33.01-9.82 40.8-26.45l84-181.13.38-.83c6.94-16.57 2.94-35.75-10.22-48.87-13.23-13.15-32.49-17.15-50.03-9.9zm-62.49 209.41v-87.58h-88.06l163.53-75.15-75.47 162.73zM248 8C111.03 8 0 119.03 0 256s111.03 248 248 248 248-111.03 248-248S384.97 8 248 8zm0 448c-110.28 0-200-89.72-200-200S137.72 56 248 56s200 89.72 200 200-89.72 200-200 200z">
                            </path>
                        </svg>
                        <span class="ml-1">16 T</span>
                    </div>
                    11
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <dl class="grid grid-cols-1 gap-5">
            <div class="px-4 py-5 bg-white shadow rounded-lg overflow-hidden sm:p-6">
                <dt class="text-sm font-medium text-gray-500 truncate">
                    METAR
                </dt>
                <dd class="mt-1 text-2xl font-semibold text-gray-900">
                    <?= $metarDecoder->getRawMetar() ?>
                </dd>
            </div>
        </dl>
    </div>
</main>
