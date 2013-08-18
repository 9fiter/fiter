<?php

namespace Fiter\MinecraftDonationBundle\Controller;

use JMS\DiExtraBundle\Annotation as DI;
use JMS\Payment\CoreBundle\Entity\Payment;
use JMS\Payment\CoreBundle\PluginController\Result;
use JMS\Payment\CoreBundle\Plugin\Exception\ActionRequiredException;
use JMS\Payment\CoreBundle\Plugin\Exception\Action\VisitUrl;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\RedirectResponse;


use Fiter\MinecraftDonationBundle\Entity\Pedido as Pedido;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


use Symfony\Component\Security\Core\Exception\AccessDeniedException;







use JMS\Payment\CoreBundle\Entity\PaymentInstruction;
use Wikp\PaymentMtgoxBundle\Plugin\MtgoxPaymentPlugin;
use Wikp\PaymentMtgoxBundle\Mtgox\RequestType\MtgoxTransactionUrlRequest;
use JMS\Payment\CoreBundle\Model\FinancialTransactionInterface;

/**
 * @Route("/payments")
 */
class PaymentController extends Controller{

    /** @DI\Inject */
    private $request;

    /** @DI\Inject */
    private $router;

    /** @DI\Inject("doctrine.orm.entity_manager") */
    private $em;

    /** @DI\Inject("payment.plugin_controller") */
    private $ppc;

    /**
     * @Route("/return", name = "payment_return")
     * @Template
     */
    public function returnAction(){ return array(); }

    /**
     * @Route("/cancel", name = "payment_cancel")
     * @Template
     */
    public function cancelAction(){ return array(); }

    /**
     * @Route("/{orderId}/details", name = "payment_details")
     * @Template
     */
    public function detailsAction($orderId){
        $em = $this->getDoctrine()->getManager();
        $order = $em->getRepository('FiterMinecraftDonationBundle:Pedido')->find($orderId);
        //ladybug_dump($order);
        //ladybug_dump($order->getAmount());
        //ladybug_dump($this);
        $form = $this->getFormFactory()->create('jms_choose_payment_method', null, array(
            'amount'   => $order->getAmount(),
            'currency' => 'EUR',
            //'allowed_methods' => array('paypal_express_checkout'),
            'default_method' => 'paypal_express_checkout', // Optional
            'predefined_data' => array(
                'bitcoin_express_checkout' => array(
                    'return_url' => $this->router->generate('payment_complete', array(
                        'orderId' => $order->getId(),
                    ), true),
                    'cancel_url' => $this->router->generate('payment_cancel', array(
                        'orderId' => $order->getId(),
                    ), true)
                ),
                'paypal_express_checkout' => array(
                    'return_url' => $this->router->generate('payment_complete', array(
                        'orderId' => $order->getId(),
                    ), true),
                    'cancel_url' => $this->router->generate('payment_cancel', array(
                        'orderId' => $order->getId(),
                    ), true)
                ),
                'wikp_mtgox_ipn' => array(),
                'mtgox_instant_payment' => array(),
                'wikp_mtgox_ipn' => array(),
                
            ),
        ));
        //ladybug_dump($form);
        if ('POST' === $this->request->getMethod()) {
            //ladybug_dump($this->request);
            $payment_method= $this->request->request->get('jms_choose_payment_method');
            //ladybug_dump($payment_method);
            //ladybug_dump($payment_method['method']);
            $isMtGox = $payment_method['method'] == "wikp_mtgox_ipn";

            if($isMtGox){
                //ladybug_dump("Es MtGox!!");

                

                $this->ppc->addPlugin($this->get('wikp_payment_mtgox.plugin'));
                $this->ppc->createPaymentInstruction(
                    //$instruction = $form->getData()
                    $instruction = new PaymentInstruction(
                        $order->getAmount(),
                        'EUR',
                        MtgoxPaymentPlugin::SYSTEM_NAME
                    )
                );
                $order->setPaymentInstruction($instruction);
                $this->em->persist($order);
                $this->em->flush($order);

                //ladybug_dump('añadio la payment instruccion');

                if (FinancialTransactionInterface::STATE_PENDING == $instruction->getState()) {

                    $urlRequest = new MtgoxTransactionUrlRequest();

                    $urlRequest->setAmount($order->getAmount());

                    $urlRequest->setIpnUrl($this->generateUrl('wikp_payment_mtgox_ipn', array(), true));
                    $urlRequest->setDescription( //info for the user visible on the payment page
                        sprintf('You are about to pay for order id=%d', $order->getId())
                    );


                    $urlRequest->setAdditionalData($order->getId()); //could be useful for debugging

                    $urlRequest->setCurrency('EUR');
                    
                    //$urlRequest->setReturnSuccess(
                    //    $this->generateUrl('_demo_payment_successful', array(), true)
                    //);
                    //ladybug_dump('entra en el if');
                    //$urlRequest->setReturnFailure(
                    //    $this->generateUrl('_demo_payment_canceled', array(), true)
                    //);



                    return $this->redirect(
                        $this->get('wikp_payment_mtgox.plugin')->getMtgoxTransactionUrl($urlRequest)
                    );
                }


            }else{
                //ladybug_dump("No es MtGox!!");
                //ladybug_dump($form);
                $form->bindRequest($this->request);
                //ladybug_dump($form);            
                if ($form->isValid()) {
                    //ladybug_dump("formulario valido");
                    $this->ppc->createPaymentInstruction($instruction = $form->getData());

                    $order->setPaymentInstruction($instruction);
                    $this->em->persist($order);
                    $this->em->flush($order);

                    return new RedirectResponse($this->router->generate('payment_complete', array(
                        'orderId' => $order->getId(),
                    )));
                }
            }
            
            
        }
        $cart=unserialize($order->getCart());
        foreach ($cart['products'] as &$product) {
            $product['product'] = $em->getRepository('FiterMinecraftDonationBundle:Product')->findOneById($product['id']);
        }

        $usuario = null;
        $em = $this->getDoctrine()->getManager('minecraft');
        $session  = $this->get("session");
        $user = $session->get("MinecraftUser");
        if($user) $usuario = $em->getRepository('FiterMinecraftBundle:Authme')->findOneByUsername($user);


        if($order->getUser() == $user){
            return array(
                'form' => $form->createView(),
                'cart' => $cart,
                'usuario' => $usuario
            
            ); 
        }else throw new AccessDeniedException("No tienes permiso para ver este pedido");
        
        
    }

    /** @DI\LookupMethod("form.factory") */
    protected function getFormFactory() { }

    /**
     * @Route("/{orderId}/complete", name = "payment_complete")
     */
    public function completeAction($orderId){
        $session  = $this->get("session");
        $em = $this->getDoctrine()->getManager();
        $order = $em->getRepository('FiterMinecraftDonationBundle:Pedido')->find($orderId);
        //ladybug_dump($order->getCart());
        $instruction = $order->getPaymentInstruction();
        if (null === $pendingTransaction = $instruction->getPendingTransaction()) {
            $payment = $this->ppc->createPayment($instruction->getId(), $instruction->getAmount() - $instruction->getDepositedAmount());
        }else{ $payment = $pendingTransaction->getPayment(); }
        $result = $this->ppc->approveAndDeposit($payment->getId(), $payment->getTargetAmount());
        if (Result::STATUS_PENDING === $result->getStatus()) {
            $ex = $result->getPluginException();
            if ($ex instanceof ActionRequiredException) {
                $action = $ex->getAction();
                if ($action instanceof VisitUrl) { return new RedirectResponse($action->getUrl()); }
                throw $ex;
            }
        }else if(Result::STATUS_SUCCESS !== $result->getStatus()) {
            $session->getFlashBag()->add('error', 'Transaction was not successful: '.$result->getReasonCode() );
            return $this->redirect($this->generateUrl('payment_details', array('orderId' => $order->getId()  )));
            //throw new \RuntimeException('Transaction was not successful: '.$result->getReasonCode());
        }
        // payment was successful, do something interesting with the order
        return $this->redirect($this->generateUrl('donation_thanks'));
    }

}