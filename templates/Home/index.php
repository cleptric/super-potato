<header class="bg-white shadow-sm">
    <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
        <h1 class="text-lg leading-6 font-semibold text-gray-900">
            Airports
        </h1>
    </div>
</header>
<main>
    <?php foreach($atis as $airprotAtis): ?>
        <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <div class="px-4 py-4 sm:px-0">
                <div>
                    <h3 class="flex items-center text-lg leading-6 font-medium text-gray-900">
                        <span class="text-gray-700 mr-2">
                            <?= $airprotAtis['airport_name'] ?>
                        </span>
                        <span class="text-gray-500 mr-2">ATIS Information</span>
                        <span class="font-bold mr-2"><?= $airprotAtis['atis_letter'] ?></span>
                        <span class="text-gray-500 mr-2">at time</span>
                        <span class="font-bold mr-2"><?= $airprotAtis['time'] ?>Z</span>
                    </h3>
                    <dl class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-3">
                        <div class="px-4 py-5 bg-white shadow rounded-lg overflow-hidden sm:p-6">
                            <dt class="text-sm font-medium text-gray-500 truncate">
                                Depature Runway
                            </dt>
                            <dd class="mt-1 text-3xl font-semibold text-gray-900">
                                <?= implode(' & ', $airprotAtis['depature_runway']) ?>
                            </dd>
                        </div>

                        <div class="px-4 py-5 bg-white shadow rounded-lg overflow-hidden sm:p-6">
                            <dt class="text-sm font-medium text-gray-500 truncate">
                                Arrival Runway
                            </dt>
                            <dd class="mt-1 text-3xl font-semibold text-gray-900">
                                <?= implode(' & ', $airprotAtis['arrival_runway']) ?>
                            </dd>
                        </div>

                        <div class="px-4 py-5 bg-white shadow rounded-lg overflow-hidden sm:p-6">
                            <dt class="text-sm font-medium text-gray-500 truncate">
                                Transition Level
                            </dt>
                            <dd class="mt-1 text-3xl font-semibold text-gray-900">
                                FL <?= $airprotAtis['transition_level'] ?>
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</main>
