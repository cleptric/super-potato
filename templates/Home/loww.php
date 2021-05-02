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
                    <div class="absolute text-center bg-blue-500 rounded-md p-3">
                        <i class="far fa-lg fa-windsock w-6 text-white"></i>
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
                        <div class="absolute text-center bg-blue-500 rounded-md p-3">
                            <i class="far fa-lg fa-wind-warning w-6 text-white"></i>
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
                        <div class="absolute text-center bg-blue-500 rounded-md p-3">
                            <i class="far fa-lg fa-wind w-6 text-white"></i>
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
                    <div class="absolute text-center bg-blue-500 rounded-md p-3">
                        <i class="far fa-lg fa-clouds w-6 text-white"></i>
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
            <div class="absolute w-[120px] h-[550px] flex flex-col justify-between border border-gray-200 rounded-lg transform -rotate-40" style="left: 220px; top: 40px;">
                <div class="relative x-4 py-5 text-center text-2xl font-black <?= in_array('34', $atis['depature_runway']) || in_array('34', $atis['arrival_runway']) ? 'rounded-lg bg-blue-200': ''?>">
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
        <dl class="grid grid-cols-1 gap-5">
            <div class="px-4 py-5 bg-white shadow rounded-lg overflow-hidden sm:p-6">
                <dt class="text-sm font-medium text-gray-500 truncate">
                    Actions
                </dt>
                <dd class="mt-1 text-2xl font-semibold text-gray-900">
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
