<?php
/**
 * Created by PhpStorm.
 * User: ddiimmkkaass
 * Date: 24.03.16
 * Time: 23:11
 */

namespace App\Widgets\Done;

use App\Models\Done;
use Pingpong\Widget\Widget;

class DoneWidget extends Widget
{

    protected $view = 'default';


    public function index()
    {

        $list = Done::positionSorted()->visible()->get();

        return view('widgets.done.index')->with('dones', $list)->render();

    }
}