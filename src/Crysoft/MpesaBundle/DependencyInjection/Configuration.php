<?php

namespace Crysoft\MpesaBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from app/config files.
 *
 *
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('crysoft_mpesa');

        $rootNode
            ->children()
                ->arrayNode('mpesa')
                     ->children()
                        ->scalarNode('endpoint')
                            ->info('Safaricom API endpoint to be queried for transactional requests.')
                            ->defaultValue('https://safaricom.co.ke/mpesa_online/lnmo_checkout_server.php?wsdl')
                        ->end()// endpoint
                        ->scalarNode('token_endpoint')
                        ->info('Safaricom API endpoint to be queried for getting Tokens.')
                        ->defaultValue('https://sandbox.safaricom.co.ke/mpesa/transactionstatus/v1/query')
                        ->end()// token_endpoint
                        ->scalarNode('status_endpoint')
                        ->info('Safaricom API endpoint to be queried for transaction status requests.')
                        ->defaultValue('https://sandbox.safaricom.co.ke/mpesa/transactionstatus/v1/query')
                        ->end()// status_endpoint
                        ->scalarNode('callback_url')
                            ->info('The fully qualified callback URL to be queried by Safaricom\'s API on transaction completion.')
                        ->end()// callback_url
                        ->enumNode('callback_method')
                            ->info('The callback method to be used, default is POST.')
                            ->values(array('POST','GET'))
                            ->defaultValue('POST')
                        ->end()// callback_method
                        ->integerNode('paybill_number')
                            ->info('The merchant\'s Paybill number.')
                        ->end()// paybill_number
                        ->scalarNode('pass_key')
                            ->info('The SAG Passkey given on registration.')
                        ->end()// SAG passkey
                        ->scalarNode('consumer_secret')
                        ->info('The Consumer Secret.')
                        ->end()// Consumer Secret
                        ->scalarNode('consumer_key')
                        ->info('The Consumer Key.')
                        ->end()// Consumer Key
                     ->end()
                ->end()// mpesa
            ->end();

        return $treeBuilder;
    }
}
