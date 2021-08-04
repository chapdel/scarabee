<?php

namespace Chapdel\Scarabee;

use Chapdel\Scarabee\Observers\QueryObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;
use Spatie\Backtrace\Backtrace;
use Symfony\Component\VarDumper\Caster\ReflectionCaster;
use Symfony\Component\VarDumper\Cloner\VarCloner;
use Symfony\Component\VarDumper\Dumper\HtmlDumper;

class Scarabee
{
    private $active = true;
    public $color = false;

    public function checkActive()
    {
        $this->active = config('app.debug') != false && !App::environment('production') && config('scarabee.enable');
    }

    public function sendRequest($data)
    {
        try {
            Http::post(config('scarabee.url') . ':' . config('scarabee.port') . '/', $data);
        } catch (\Throwable $th) {
        }
    }

    private function createTrace()
    {
        $backtrace = Backtrace::create()->frames();

        return [
            'class' => $backtrace[2]->class,
            'file_name' => basename($backtrace[2]->file),
            'file_path' => $backtrace[2]->file,
            'line' => $backtrace[2]->lineNumber,
        ];
    }

    private function customDumper($data)
    {
        $cloner = new VarCloner();
        $cloner->addCasters(ReflectionCaster::UNSET_CLOSURE_FILE_INFO);
        $dumper = new HtmlDumper();
        $dumper->setTheme('light');

        return $dumper->dump($cloner->cloneVar($data), true);
    }

    public function showQueries()
    {
        if (!$this->active) {
            return;
        }

        $called_by = $this->createTrace();

        app(QueryObserver::class)->enable($called_by);
    }

    public function stopShowingQueries()
    {
        if (!$this->active) {
            return;
        }

        $called_by = $this->createTrace();

        app(QueryObserver::class)->disable($called_by);
    }

    public function model(Model $model)
    {
        if (!$this->active) {
            return;
        }

        $called_by = $this->createTrace();

        $this->sendRequest([
            'class_name' => get_class($model),
            'model' => $model,
            'view' => view('scarabee::model', [
                'model' => $model,
                'dump' => $this->customDumper($model->toArray()),
                'relation' => $this->customDumper($model->getRelations()),
                'call' => $called_by,
            ])->render(),
        ]);
    }

    public function dump(...$args)
    {
        $called_by = $this->createTrace();

        $this->sendRequest([
            'view' => view('scarabee::dump', [
                'dumps' => collect($args)->map(function ($dumpValue) {
                    return $this->customDumper($dumpValue);
                }),
                'call' => $called_by,
            ])->render(),
        ]);
    }

    public function mail($mailable)
    {
        $called_by = $this->createTrace();

        $this->sendRequest([
            'view' => view('scarabee::mail', [
                'mailable_class' => get_class($mailable),
                'from' => $this->convertToPersons($mailable->from),
                'subject' => $mailable->subject,
                'to' => $this->convertToPersons($mailable->to),
                'cc' => $this->convertToPersons($mailable->cc),
                'bcc' => $this->convertToPersons($mailable->bcc),
                'html' => $mailable->render(),
                'call' => $called_by,
            ])->render(),
        ]);
    }

    private function convertToPersons(array $persons): array
    {
        return collect($persons)
            ->map(function (array $person) {
                return [
                    'email' => $person['address'],
                    'name' => $person['name'] ?? '',
                ];
            })
            ->toArray();
    }
}
