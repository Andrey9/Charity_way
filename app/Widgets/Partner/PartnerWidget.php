<?php

namespace App\Widgets\Partner;

use App\Models\Partner;
use Pingpong\Widget\Widget;

class PartnerWidget extends Widget
{
    protected $view = 'default';

    public function index()
    {

        $list = Partner::withTranslations()->joinTranslations('partners')->positionSorted()->visible()
            ->select(
                'partner_translations.title as t',
                'image',
                'link'
            )
            ->get();

        return view('widgets.partner.index')->with('list', $list)->render();

    }
}