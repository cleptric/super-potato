<header class="bg-white shadow-sm">
    <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
        <h1 class="text-lg leading-6 font-semibold text-gray-900">
            Wien-Schwechat (LOWW)
        </h1>
    </div>
</header>

<main>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <dl class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-4">
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
                    Source
                </dt>
                <dd class="mt-1 text-3xl font-semibold text-gray-900">
                    VATSIM ATIS
                </dd>
            </div>
        </dl>
    </div>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <dl class="mt-5 grid grid-cols-1 gap-5 lg:grid-cols-4">
            <div class="relative bg-white pt-5 px-4 pb-5 sm:pt-6 sm:px-6 shadow rounded-lg overflow-hidden">
                <dt>
                    <div class="absolute text-center bg-blue-200 rounded-md p-3">
                        <i class="far fa-lg fa-windsock w-6 text-blue-500"></i>
                    </div>
                    <p class="ml-16 text-sm font-medium text-gray-500 truncate">
                        Wind
                    </p>
                </dt>
                <dd class="ml-16 flex items-baseline">
                    <p class="text-2xl font-semibold text-gray-900">
                        <?= $metarDecoder->getSurfaceWind()->getMeanDirection()->getValue(); ?>° / <?= $metarDecoder->getSurfaceWind()->getMeanSpeed()->getValue(); ?>kts
                    </p>
                </dd>
            </div>
            <?php if ($metarDecoder->getSurfaceWind()->getSpeedVariations()): ?>
                <div class="relative bg-white pt-5 px-4 pb-5 sm:pt-6 sm:px-6 shadow rounded-lg overflow-hidden">
                    <dt>
                        <div class="absolute text-center bg-blue-200 rounded-md p-3">
                            <i class="far fa-lg fa-wind-warning w-6 text-blue-500"></i>
                        </div>
                        <p class="ml-16 text-sm font-medium text-gray-500 truncate">
                            Maximum
                        </p>
                    </dt>
                    <dd class="ml-16 flex items-baseline">
                        <p class="text-2xl font-semibold text-gray-900">
                            <?= $metarDecoder->getSurfaceWind()->getSpeedVariations()->getValue() ?>kts
                        </p>
                    </dd>
                </div>
            <?php endif; ?>
            <?php if ($metarDecoder->getSurfaceWind()->getDirectionVariations()): ?>
                <div class="relative bg-white pt-5 px-4 pb-5 sm:pt-6 sm:px-6 shadow rounded-lg overflow-hidden">
                    <dt>
                        <div class="absolute text-center bg-blue-200 rounded-md p-3">
                            <i class="far fa-lg fa-wind w-6 text-blue-500"></i>
                        </div>
                        <p class="ml-16 text-sm font-medium text-gray-500 truncate">
                            Variable Wind
                        </p>
                    </dt>
                    <dd class="ml-16 flex items-baseline">
                        <p class="text-2xl font-semibold text-gray-900">
                            <?= $metarDecoder->getSurfaceWind()->getDirectionVariations()[0]->getValue() ?> / <?= $metarDecoder->getSurfaceWind()->getDirectionVariations()[1]->getValue() ?>
                        </p>
                    </dd>
                </div>
            <?php endif; ?>
            <div class="relative bg-white pt-5 px-4 pb-5 sm:pt-6 sm:px-6 shadow rounded-lg overflow-hidden">
                <dt>
                    <div class="absolute text-center bg-blue-200 rounded-md p-3">
                        <i class="far fa-lg fa-clouds w-6 text-blue-500"></i>
                    </div>
                    <p class="ml-16 text-sm font-medium text-gray-500 truncate">
                        Conditions
                    </p>
                </dt>
                <dd class="ml-16 flex items-baseline">
                    <p class="text-2xl font-semibold text-gray-900">
                        VMC
                    </p>
                </dd>
            </div>
        </dl>
    </div>

    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="relative h-[620px] px-4 py-5 bg-white shadow rounded-lg overflow-hidden sm:p-6">
            <div class="flex justify-end">
                <div class="rounded-md bg-yellow-50 py-4 px-6 mr-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <!-- Heroicon name: solid/wifi -->
                            <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-yellow-800">
                                Missed Approach
                            </h3>
                        </div>
                    </div>
                </div>

                <?php if ($metarDecoder->getWindshearRunways()): ?>
                    <div class="rounded-md bg-red-50 py-4 px-6">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <!-- Heroicon name: solid/x-circle -->
                                <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">
                                    Windshear on Runway <?= implode(' & ', $metarDecoder->getWindshearRunways()); ?>
                                </h3>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- RWY closed: bg-red-500 -->
            <div class="absolute w-[120px] h-[550px] flex flex-col justify-between border border-gray-200 rounded-lg transform -rotate-40" style="left: 220px; top: 40px;">
                <div class="relative x-4 py-5 text-center text-2xl font-black <?= in_array('34', $atis['depature_runway']) || in_array('34', $atis['arrival_runway']) && false ? 'rounded-lg bg-blue-200': ''?>">
                    <?php if (in_array('34', $atis['arrival_runway'])): ?>
                        <div class="absolute h-6 w-6" style="top: -40px; right: 50%; transform: translateX(50%) rotate(180deg);">
                            <i class="far fa-lg fa-arrow-to-top"></i>
                        </div>
                    <?php endif; ?>
                    <?php if (in_array('34', $atis['depature_runway'])): ?>
                        <div class="absolute h-6 w-6" style="bottom: -40px; right: 50%; transform: translateX(50%) rotate(180deg);">
                            <i class="far fa-lg fa-arrow-up"></i>
                        </div>
                    <?php endif; ?>

                    <div class="absolute flex items-center text-yellow-400 font-medium transform rotate-40" style="top: 50px; right: -80px;">
                        <i class="far fa-location-circle" style="transform: rotate(45deg);"></i>
                        <span class="ml-1">12 C</span>
                    </div>
                    34
                </div>
                <!-- <div class="text-center">
                    <i class="far fa-2x fa-times text-red-800"></i>
                </div>
                <div class="text-center">
                    <i class="far fa-2x fa-times text-red-800"></i>
                </div>
                <div class="text-center">
                    <i class="far fa-2x fa-times text-red-800"></i>
                </div>
                <div class="text-center">
                    <i class="far fa-2x fa-times text-red-800"></i>
                </div> -->
                <div class="relative px-4 py-5 text-center text-2xl font-black <?= in_array('16', $atis['depature_runway']) || in_array('16', $atis['arrival_runway']) ? 'rounded-lg bg-blue-200': ''?>">
                    <?php if (in_array('16', $atis['arrival_runway'])): ?>
                        <div class="absolute h-6 w-6" style="bottom: -40px; right: 50%; transform: translateX(50%);">
                            <i class="far fa-lg fa-arrow-to-top"></i>
                        </div>
                    <?php endif; ?>
                    <?php if (in_array('16', $atis['depature_runway'])): ?>
                        <div class="absolute h-6 w-6" style="top: -40px; right: 50%; transform: translateX(50%);">
                            <i class="far fa-lg fa-arrow-up"></i>
                        </div>
                    <?php endif; ?>

                    <div class="absolute flex items-center text-yellow-400 text-md font-medium transform rotate-40" style="top: 10px; left: -80px;">
                        <i class="far fa-location-circle" style="transform: rotate(45deg);"></i>
                        <span class="ml-1">12 C</span>
                    </div>
                    16
                </div>
            </div>
            <div class="absolute w-[120px] h-[550px] flex flex-col justify-between border border-gray-200 rounded-lg transform -rotate-90" style="right: 300px; bottom: 0px;">
                <div class="absolute flex items-center text-md font-medium transform rotate-90" style="top: 50%; right: -110px; transform: translateY(50%) rotate(90deg);">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-medium bg-blue-100 text-blue-800">
                      <svg class="-ml-0.5 mr-1.5 h-2 w-2 text-blue-400" fill="currentColor" viewBox="0 0 8 8">
                        <circle cx="4" cy="4" r="3" />
                      </svg>
                      Visual Depature<i class="ml-2 far fa-level-up-alt"></i>
                    </span>
                </div>

                <div class="relative px-4 py-5 text-center text-2xl font-black <?= in_array('29', $atis['depature_runway']) || in_array('29', $atis['arrival_runway']) ? 'rounded-lg bg-blue-200': ''?>">
                    <?php if (in_array('29', $atis['arrival_runway'])): ?>
                        <div class="absolute h-6 w-6" style="top: -40px; right: 50%; transform: translateX(50%) rotate(180deg);">
                            <i class="far fa-lg fa-arrow-to-top"></i>
                        </div>
                    <?php endif; ?>
                    <?php if (in_array('29', $atis['depature_runway'])): ?>
                        <div class="absolute h-6 w-6" style="bottom: -40px; right: 50%; transform: translateX(50%) rotate(180deg);">
                            <i class="far fa-lg fa-arrow-up"></i>
                        </div>
                    <?php endif; ?>

                    <div class="absolute flex items-center text-green-400 text-md font-medium transform rotate-90" style="top: 20px; right: -60px;">
                        <i class="far fa-location-circle" style="transform: rotate(45deg);"></i>
                        <span class="ml-1">0 T</span>
                    </div>
                    29
                </div>
                <div class="relative px-4 py-5 text-center text-2xl font-black <?= in_array('11', $atis['depature_runway']) || in_array('11', $atis['arrival_runway']) ? 'rounded-lg bg-blue-200': ''?>">
                    <?php if (in_array('11', $atis['arrival_runway'])): ?>
                        <div class="absolute h-6 w-6" style="bottom: -40px; right: 50%; transform: translateX(50%);">
                            <i class="far fa-lg fa-arrow-to-top"></i>
                        </div>
                    <?php endif; ?>
                    <?php if (in_array('11', $atis['depature_runway'])): ?>
                        <div class="absolute h-6 w-6" style="top: -40px; right: 50%; transform: translateX(50%)">
                            <i class="far fa-lg fa-arrow-up"></i>
                        </div>
                    <?php endif; ?>

                    <div class="absolute flex items-center text-red-400 text-md font-medium transform rotate-90" style="top: 20px; right: -60px;">
                        <i class="far fa-location-circle" style="transform: rotate(-135deg);"></i>
                        <span class="ml-1">16 T</span>
                    </div>
                    11
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <dl class="grid grid-cols-1 gap-5 sm:grid-cols-3">
            <div class="px-4 py-5 bg-white shadow rounded-lg overflow-hidden sm:p-6">
                <dt class="text-sm font-medium text-gray-500 truncate">
                    Visual Depatures
                </dt>
                <dd class="mt-1 text-3xl font-semibold text-gray-900">
                    <span class="relative z-0 inline-flex shadow-sm rounded-md">
                        <button type="button" class="relative inline-flex items-center px-4 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                            North
                        </button>
                        <button type="button" class="-ml-px relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                            East
                        </button>
                        <button type="button" class="-ml-px relative inline-flex items-center px-4 py-2 border border-blue-300 bg-blue-200 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                            <i class="far fa-level-up-alt mr-1 text-blue-800"></i> South
                        </button>
                        <button type="button" class="-ml-px relative inline-flex items-center px-4 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                            West
                        </button>
                    </span>
                </dd>
            </div>

            <div class="px-4 py-5 bg-white shadow rounded-lg overflow-hidden sm:p-6">
                <dt class="text-sm font-medium text-gray-500 truncate">
                    Runway Closed
                </dt>
                <dd class="mt-1 text-3xl font-semibold text-gray-900">
                    <span class="relative z-0 inline-flex shadow-sm rounded-md">
                      <button type="button" class="relative inline-flex items-center px-4 py-2 rounded-l-md border border-red-300 bg-red-200 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                        <i class="far fa-times mr-1 text-red-800"></i> 16 / 34
                      </button>
                      <button type="button" class="-ml-px relative inline-flex items-center px-4 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                        29 / 11
                      </button>
                    </span>
                </dd>
            </div>

            <div class="px-4 py-5 bg-white shadow rounded-lg overflow-hidden sm:p-6">
                <dt class="text-sm font-medium text-gray-500 truncate">
                    Missed Approach
                </dt>
                <dd class="mt-1 text-3xl font-semibold text-gray-900">
                    <button type="button" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="far fa-bells mr-2"></i> Trigger Notification
                    </button>
                </dd>
            </div>

        </dl>
    </div>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <dl class="mt-5 grid grid-cols-1 gap-5">
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
