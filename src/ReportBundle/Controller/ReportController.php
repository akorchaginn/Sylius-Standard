<?php
/**
 * Created by PhpStorm.
 * User: akorchagin
 * Date: 25.12.2018
 * Time: 7:52
 */

namespace ReportBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller as Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

/**
 * @param Request $request
 *
 * @return Response
 */
class ReportController extends Controller
{

    /**
     * @var EngineInterface
     */
    private $templatingEngine;

    public function __construct(EngineInterface $templatingEngine)
    {
        $this->templatingEngine = $templatingEngine;
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function incomeAction(Request $request)
    {
        $data = '';
        $form = $this->get('report.income.form');

        $form->handleRequest($request);

        if ($form->isValid()) {
            $formData = $form->getData();

            $provider = $this->get('report.provider.income');

            $data = $provider->setDateFrom($formData['date_from']
                    )->setDateTo($formData['date_to']
                    )->setDoctrineConnection($this->getDoctrine()->getConnection()
                    )->getData();

        }

        return $this->templatingEngine->renderResponse(
            '@ReportBundle/Resources/views/income.html.twig',
                ['data' => $data,
                'form' => $form->createView()]
        );
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function grossProfitAction(Request $request)
    {
        $data = '';
        $form = $this->get('report.grossProfit.form');

        $form->handleRequest($request);

        if ($form->isValid()) {
            $formData = $form->getData();

            $provider = $this->get('report.provider.grossProfit');

            $data = $provider->setDateFrom($formData['date_from']
            )->setDateTo($formData['date_to']
            )->setDoctrineConnection($this->getDoctrine()->getConnection()
            )->getData();

        }

        return $this->templatingEngine->renderResponse(
            '@ReportBundle/Resources/views/grossProfit.html.twig',
            ['data' => $data,
                'form' => $form->createView()]
        );
    }
}