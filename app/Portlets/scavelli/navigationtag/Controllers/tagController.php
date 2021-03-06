<?php

namespace App\Portlets\scavelli\navigationtag\Controllers;

use App\Repositories\RepositoryInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class tagController extends Controller
{

    private $rp;


    public function __construct(RepositoryInterface $rp) {
        $this->rp = $rp->setModel('App\Models\Content\Tag');
    }

    /**
     * Mostra il web form per la configurazione della portlet
     * @param $portlet
     * @param Request $request
     * @return string
     */
    public function configPortlet($portlet, Request $request) {
        $conf = ['inpage'=>'','ord'=>0,'dir'=>0,'service'=>'','comunication'=>$portlet->pivot->comunication];
        if(!empty($portlet->pivot->setting)) $conf = array_merge($conf,json_decode($portlet->pivot->setting, true));


        $pages = $this->rp->setModel('App\Models\Content\Page')->where('status_id',1)->orderBy('name')->pluck('name','slug')->toArray();
        $services = $this->rp->setModel('App\Models\Content\Service')->where('id',1)->pluck('name','class')->toArray();
        $selectOrder = $this->selectOrder();

        return view('navigationtag::preferences')->with(compact(
            'services',
            'pages',
            'conf',
            'selectOrder'
        ));
    }

    /**
     * @return array
     * Definisco i valori dei campi select ord e dir
     */
    private function selectOrder() {
        return  ['ord'=>['Inserimento','Titolo','Data di Creazione','Data di Modifica'],'dir'=>['Ascendente','Discendente']];
    }

}