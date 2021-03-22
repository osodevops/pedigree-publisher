<?php

namespace App\Observers;

use Exception;
use App\RepoStat;
use App\Inventory;
use App\Handlers\ProducerHandler;
use Illuminate\Support\Facades\Log;

class RepoStatObserver
{
    /**
     * Topic name
     */
    const KAFKA_TOPIC = 'repo_stats';

    /**
     * Publish error message
     */
    const PUBLISH_ERROR_MESSAGE = 'Publish message to kafka failed';

    /**
     * Kafka producer
     *
     * @var \App\Handlers\Kafka\ProducerHandler
     */
    protected $producerHandler;

    /**
     * repo statObserver constructor
     *
     * @param \App\Handlers\Kafka\ProducerHandler $producerHandler
     */
    public function __construct(ProducerHandler $producerHandler)
    {
        $this->producerHandler = $producerHandler;
    }

    /**
     * Handle the repo stat "created" event.
     *
     * @param  \App\RepoStat $repo
     * @return void
     */
    public function created(RepoStat $repo)
    {
        $this->pushToKafka($repo);
    }

    /**
     * Handle the repo stat "updated" event.
     *
     * @param  \App\RepoStat $repo
     * @return void
     */
    public function updated(RepoStat $repo)
    {
        $this->pushToKafka($repo);
    }

    /**
     * Handle the repo stat "deleted" event.
     *
     * @param  \App\RepoStat $repo
     * @return void
     */
    public function deleted(RepoStat $repo)
    {
        $this->pushToKafka($repo);
    }

    /**
     * Push repo stats to kafka
     *
     * @param  \App\RepoStat $repo
     * @return void
     */
    protected function pushToKafka(RepoStat $repo)
    {
        try {
            $this->producerHandler->setTopic(self::KAFKA_TOPIC)
                ->send($repo->toJson());
        } catch (Exception $e) {
            Log::critical(self::PUBLISH_ERROR_MESSAGE, [
                'error' => $e->getMessage(),
                'code' => $e->getCode()
            ]);
        }
    }
}
