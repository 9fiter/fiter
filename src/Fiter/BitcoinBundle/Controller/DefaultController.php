<?php

namespace Fiter\BitcoinBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\Request;


use Symfony\Component\HttpFoundation\RedirectResponse;
//use Symfony\Component\HttpFoundation\Response;


/**
 * Default controller.
 * @Route("/bitcoin")
 */
class DefaultController extends Controller{

    /**
     * @Route("/", name="bitcoin")
     * @Template()
     */
    public function indexAction(){
    	$bitcoind = $this->get('bitcoind');
        return array();
    }

    /**
     * @Route("/listaccounts", name="bitcoin_listaccounts")
     * @Template()
     */
    public function listaccountsAction(){
    	$bitcoind = $this->get('bitcoind');
    	$listaccounts = $bitcoind->listaccounts(); //Devuelve objeto que tiene los nombres de cuenta como llaves y saldos de cuenta como valores.
        return array('listaccounts' => $listaccounts);
    }


    /**
     * @Route("/help", name="bitcoin_help")
     * @Template()
     */
    public function helpAction(){
    	$bitcoind = $this->get('bitcoind');
    	$help = $bitcoind->help();
        return array('help' => $help);
    }

    /**
     * @Route("/peerinfo", name="bitcoin_peerinfo")
     * @Template()
     */
    public function peerinfoAction(){
    	$bitcoind = $this->get('bitcoind');
    	$peerinfo = $bitcoind->getpeerinfo();
        return array('peerinfo' => $peerinfo);
    }


    /**
     * @Route("/mininginfo", name="bitcoin_mininginfo")
     * @Template()
     */
    public function mininginfoAction(){
    	$bitcoind = $this->get('bitcoind');
    	$mininginfo = $bitcoind->getmininginfo();
        return array('mininginfo' => $mininginfo);
    }

    /**
     * @Route("/txoutsetinfo", name="bitcoin_txoutsetinfo")
     * @Template()
     */
    public function txoutsetinfoAction(){
    	$bitcoind = $this->get('bitcoind');
    	$txoutsetinfo = $bitcoind->gettxoutsetinfo();
        return array('txoutsetinfo' => $txoutsetinfo);
    }


    /**
     * @Route("/getaccountaddress/{account}", name="bitcoin_getaccountaddress")
     * @Template()
     */
    public function getaccountaddressAction($account){
    	$bitcoind = $this->get('bitcoind');
    	$accountaddress = $bitcoind->getaccountaddress($account); //Devuelve la dirección bitcoin actual para recibir pagos a esta cuenta.
        return array(
        	'accountaddress' => $accountaddress,
        	'account' => $account,
        );
    }

    /**
     * @Route("/getaddressesbyaccount/{account}", name="bitcoin_getaddressesbyaccount")
     * @Template()
     */
    public function getaddressesbyaccountAction($account){
    	$bitcoind = $this->get('bitcoind');
    	$addresses = $bitcoind->getaddressesbyaccount($account); //Devuelve la dirección bitcoin actual para recibir pagos a esta cuenta.
        return array(
        	'addresses' => $addresses,
        	'account' => $account,
        );
    }



    /**
     * @Route("/getreceivedbyaddress/{address}", name="bitcoin_getreceivedbyaddress")
     * @Template()
     */
    public function getreceivedbyaddressAction($address){
    	$bitcoind = $this->get('bitcoind');
    	$received = $bitcoind->getreceivedbyaddress($address); //Devuelve la dirección bitcoin actual para recibir pagos a esta cuenta.
    	ladybug_dump($received);
        return array(
        	'received' => $received,
        	'address' => $address,
        );
    }










	/**
     * @Route("/getnewaddress/form/", name="bitcoin_getnewaddress_form")
     * @Template()
     */
    public function getnewaddressFormAction(){
        return array();
    }
    /**
     * @Route("/getnewaddress", name="bitcoin_getnewaddress")
     * @Template()
     */
    public function getnewaddressAction(Request $request){
    	$post = $this->get('request')->request->all();
   		$account = $post['account'];
    	$bitcoind = $this->get('bitcoind');
    	$newaddress = $bitcoind->getnewaddress($account);  //Devuelve una nueva dirección bitcoin para recibir pagos


		//$session  = $this->get("session");
    	//$translated = $this->get('translator')->trans('main.bitcoin_succes_getnewaddress');
    	//$translated = "The address has been successfully created";
        //$session->getFlashBag()->add('notice', $translated);
    	//return new RedirectResponse($this->generateURL('bitcoin_getaccountaddress', array('account'=> $account)));

        return array(
        	'newaddress' => $newaddress,
        	'account' => $account,
        );
    }

    




   

    /**
     * @Route("/getinfo", name="bitcoin_getinfo")
     * @Template()
     */
    public function getinfoAction(){
    	$bitcoind = $this->get('bitcoind');
    	//$blocktemplate = $bitcoind->getblocktemplate();
    	//$hashespersec = $bitcoind->gethashespersec();
    	//$rawmempool = $bitcoind->getrawmempool();
    	//$txout = $bitcoind->gettxout();
		//$work = $bitcoind->getwork();
		//$keypoolrefill = $bitcoind->keypoolrefill();
		//$rawmempool = $bitcoind->getrawmempool(); //Devuelve todos los ids de transacciones en el banco de memoria
    	$info = $bitcoind->getinfo();
    	$connectioncount = $bitcoind->getconnectioncount(); //Devuelve el número de conexiones a otros nodos.

		//$firstAccount = $listaccounts[0]["account"];  //obtener el nombre de la primera cuenta
		//$accountaddress = $bitcoind->getaccountaddress($firstAccount); //Devuelve la dirección bitcoin actual para recibir pagos a esta cuenta.
		//$firstAccountBalance = $bitcoind->getbalance($firstAccount); //obtener la suma de todo el dinero en las direcciones pertenecientes a la cuenta del usuario o del servidor si no se especifica [account]
		//$serverBalance = $bitcoind->getbalance(); //obtener la suma de todo el dinero en las direcciones pertenecientes a la cuenta del usuario o del servidor si no se especifica [account]
		

		//$newaddress = $bitcoind->getnewaddress("username");  //crea una nueva direccion para un pago
		//$usernameBalance = $bitcoind->getbalance("username");  //obtiene el balance de esa dirección


		//$listaddressgroupings = $bitcoind->listaddressgroupings(); //return array(0)
		//$listlockunspent = $bitcoind->listlockunspent(); //return array(0)
		//$listreceivedbyaccount = $bitcoind->listreceivedbyaccount(); //return array(0)
		//$listreceivedbyaddress = $bitcoind->listreceivedbyaddress(); //return array(0)
		//$listsinceblock = $bitcoind->listsinceblock(); //value is type null, expected str
		//$listtransactions = $bitcoind->listtransactions(); //return array(0)
		//$listunspent = $bitcoind->listunspent(); //return array(0)
		//$lockunspent = $bitcoind->lockunspent(); //lockunspent unlock? [array-of-Objects] Updates list of temporarily unspendable outputs.
		//$stop = $bitcoind->stop(); //return "Bitcoin server stopping"
		//$submitblock = $bitcoind->submitblock(); //submitblock <hex data> [optional-params-obj] [optional-params-obj] parameter is currently ignored. Attempts to submit new block to network. See https://en.bitcoin.it/wiki/BIP_0022 for full specification.
		//$walletlock = $bitcoind->walletlock(); //Removes the wallet encryption key from memory, locking the wallet. After calling this method, you will need to call walletpassphrase again before being able to call any methods which require the wallet to be unlocked.
    	
    	//ladybug_dump($bitcoind);
    	//ladybug_dump($rawmempool);
        return array(
        	'info' => $info,
        	'connectioncount' => $connectioncount,
        );
    }
  





   
  



   
}
