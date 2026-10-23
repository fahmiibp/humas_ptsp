<?php

namespace App\Ai\Agents;

use Laravel\Ai\Attributes\Model;
use Laravel\Ai\Attributes\Provider;
use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Promptable;

#[Provider('gemini')]
#[Model('gemini-3.5-flash-lite')]
class PenulisArsip implements Agent
{
    use Promptable;

    // instructions() tetap sama
    public function instructions(): string
    {
        return 'Kamu membantu staf menulis arsip dokumentasi liputan instansi pemerintah. '
            . 'Gunakan bahasa Indonesia formal, singkat, dan jelas. '
            . 'Jangan menambah fakta, nama, atau angka yang tidak diberikan. '
            . 'Jawab hanya dengan teksnya saja, tanpa markdown dan tanpa tanda kutip.';
    }
}
