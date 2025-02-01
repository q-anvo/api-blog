<?php

namespace App\Console\Commands;

use App\Console\Commands\Concerns\TransformsDataToCsv;
use Domain\Blog\Data\LightArticleData;
use Domain\Blog\Data\TopicData;
use Domain\Blog\Models\Article;
use Domain\Blog\Models\Topic;
use Domain\User\Data\UserData;
use Domain\User\Models\Author;
use Domain\User\Models\User;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use InvalidArgumentException;

use function Laravel\Prompts\confirm;
use function Laravel\Prompts\select;
use function Laravel\Prompts\spin;
use function Laravel\Prompts\text;

class ExportEntities extends Command
{
    use TransformsDataToCsv;

    protected $signature = 'export';

    protected $description = 'Export entities as CSV files';

    public function handle(): int
    {
        /** @var class-string $model */
        $model = $this->selectModel();
        $query = $this->buildQuery($model);

        if ($query->count() === 0) {
            $this->warn('No data found.');

            return self::FAILURE;
        }

        $models = $query->get();
        $filename = $this->determineFilename($model);
        $this->exportData($models, $model, $filename);

        return self::SUCCESS;
    }

    /**
     * Prompt the user to select a model for export.
     *
     * @return class-string
     */
    private function selectModel(): string
    {
        return select(
            label: 'Which model do you want to export?',
            options: [
                Article::class => 'Article',
                Topic::class => 'Topic',
                User::class => 'User',
            ],
        );
    }

    /**
     * Build the query for the selected model.
     *
     * @return \Illuminate\Database\Eloquent\Builder<\Illuminate\Database\Eloquent\Model>
     */
    private function buildQuery(string $model): Builder
    {
        return match ($model) {
            Article::class => Article::select(['id', 'title', 'url', 'summary'])->orderBy('id'),
            Topic::class => Topic::select(['id', 'label'])->orderBy('id'),
            Author::class => Author::select(['id', 'user_id'])->orderBy('id'),
            User::class => User::select(['id', 'name', 'email', 'created_at'])->orderBy('id'),
            default => throw new InvalidArgumentException('Unknown model: '.$model),
        };
    }

    /**
     * Determine the filename for the export.
     *
     * @param  class-string  $model
     */
    private function determineFilename(string $model): string
    {
        $needCustomFilename = confirm('Do you want a specific filename?', default: false);
        $modelLabel = Str::of($model)->afterLast('\\')->lower()->plural();

        return $needCustomFilename
            ? text(label: 'Enter your filename', default: $modelLabel.'.csv', required: true, validate: ['max:20'])
            : $modelLabel.'.csv';
    }

    /**
     * Perform the export process.
     *
     * @param  \Illuminate\Support\Collection<int, \Illuminate\Database\Eloquent\Model>  $models
     * @param  class-string  $model
     */
    private function exportData($models, string $model, string $filename): void
    {
        $modelLabel = Str::of($model)->afterLast('\\')->lower()->plural();

        $dataClass = match ($model) {
            Article::class => LightArticleData::class,
            Topic::class => TopicData::class,
            User::class => UserData::class,
            default => throw new InvalidArgumentException('Unknown model: '.$model),
        };

        spin(
            message: 'Exporting '.$models->count().' '.$modelLabel.'...',
            callback: fn () => $this->generateCsvFile($models, $dataClass, $filename)
        );

        $this->info('Done!');
        $this->line('Exported '.$models->count().' '.$modelLabel.' to '.storage_path($filename));
    }
}
