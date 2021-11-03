<?php
declare(strict_types=1);

namespace App\Service;

use App\Model\Entity\Airport;
use Authorization\IdentityInterface;
use Cake\Collection\CollectionInterface;
use Cake\Datasource\ModelAwareTrait;

class LogsService
{
    use ModelAwareTrait;

    public const TYPE_MISSED_APPROACH = 'Activated missed approach at ';
    public const TYPE_CLOSED_RUNWAY = 'Closed runway at ';
    public const TYPE_OPENED_RUNWAY = 'Opened runway at ';

    public function __construct()
    {
        $this->loadModel('Logs');
    }

    public function getData(): array
    {
        return $this->Logs->find()
            ->limit(5)
            ->order(['created' => 'DESC'])
            ->formatResults(function (CollectionInterface $logs) {
                return $logs->map(function ($log) {
                    return [
                        'user' => $log->user,
                        'action' => $log->action,
                        'time' => $log->created->nice(),
                    ];
                });
            })
            ->toArray();
    }

    public function createLog(IdentityInterface $user, Airport $airport, string $action): void
    {
        $log = $this->Logs->newEntity([
            'user' => $user->full_name,
            'action' => $action . $airport->name,
        ], [
            'accessibleFields' => [
                'user' => true,
                'action' => true,
            ],
        ]);

        $this->Logs->save($log);
    }

    public function deleteAllLogs(): void
    {
        $logs = $this->Logs->find()
            ->all();

        foreach ($logs as $log) {
            $this->Logs->delete($log);
        }
    }

    public function logsEmpty(): bool
    {
        return $this->Logs->find()
            ->count() === 0;
    }
}
