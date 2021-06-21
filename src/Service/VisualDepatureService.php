<?php
declare(strict_types=1);

namespace App\Service;

use App\Model\Entity\Airport;
use App\Traits\ZMQContextTrait;
use Cake\Datasource\ModelAwareTrait;
use Cake\Utility\Hash;

class VisualDepatureService
{
    use ModelAwareTrait;
    use ZMQContextTrait;

    public function __construct()
    {
        $this->loadModel('Airports');
    }

    public function toggleVisualDepature(Airport $airport, string $direction): void
    {
        $data = (array)$airport->visual_depatures;
        $key = array_search($direction, $data);
        if ($key !== false) {
            unset($data[$key]);
            $data = array_values($data);
        } else {
            $data = Hash::merge($data, $direction);
        }

        $airport = $this->Airports->patchEntity($airport, [
            'visual_depatures' => $data,
        ], [
            'accessibleFields' => [
                'visual_depatures' => true,
            ],
        ]);

        $this->Airports->save($airport);

        $this->pushMessage('refresh');
    }
}
