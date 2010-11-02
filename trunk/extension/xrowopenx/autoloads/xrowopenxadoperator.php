<?php

class wuvAdOperator
{
    function xrowOpenxAdOperator()
    {
    }

    function operatorList()
    {
        return array( 'show_ad' );
    }

    function namedParameterPerOperator()
    {
        return true;
    }

    function namedParameterList()
    {
        return array( 'show_ad' => array( 'type'     => array( 'type' => 'string',
                                                               'required' => true,
                                                               'default' => '' ),
                                          'node_id'  => array( 'type' => 'integer',
                                                               'required' => false,
                                                               'default' => 0 ) ) );
    }

    function modify( $tpl, $operatorName, $operatorParameters, &$rootNamespace, &$currentNamespace, &$operatorValue, &$namedParameters )
    {
        switch ( $operatorName )
        {
            case 'show_ad':
            {
                $type    = $namedParameters['type'];
                $nodeID  = $namedParameters['node_id'];
                $ini     = eZINI::instance( 'wuv.ini' );
                $adArray = $ini->variable( 'AdSettings', 'AdMatchArea' );
                $adArea  = $ini->variable( 'AdSettings', 'DefaultAdArea' );

                if ( is_numeric( $nodeID ) AND $nodeID > 0 )
                {
                    $node = eZContentObjectTreeNode::fetch( $nodeID );
                    if ( $node )
                    {
                        $pathString = $node->attribute( 'path_string' );
                        #eZDebug::writeDebug( $pathString, 'path' );
                        foreach( $adArray as $node => $area )
                        {
                            if ( strpos( $pathString, "/" . $node . "/" ) !== false )
                            {
                                $adArea = $area;
                                break;
                            }
                        }
                    }
                }
                elseif ( is_numeric( $nodeID ) AND $nodeID == 0 )
                {
                    $page_uri        = "";
                    $page_uri_module = "";
                    $page_uri_view   = "";
                    $page_uri        = eZURI::instance();
                    $page_uri_module = $page_uri->element( 0, false );
                    $page_uri_view   = $page_uri->element( 1, false );

                    foreach( $adArray as $node => $area )
                    {
                        if( !is_numeric( $node ) )
                        {
                            $node_uri = explode( "/", $node );
                            if( count( $node_uri == 2 ) )
                            {
                                $module = $node_uri[0];
                                $view   = $node_uri[1];

                                if ( $module == $page_uri_module AND $view == $page_uri_view )
                                {
                                    $adArea = $area;
                                    break;
                                }
                                elseif ( $module == $page_uri_module AND $view == "*" )
                                {
                                    $adArea = $area;
                                    break;
                                }
                            }
                        }
                    }
                }
                elseif ( is_string( $nodeID ) AND $nodeID != '0' )
                {
                    if( array_key_exists( $nodeID, $adArray ) )
                    {
                        $adArea = $adArray[$nodeID];
                    }
                }

                $positionArray = $ini->variable( 'AdSettings', 'AdPositionArray' );
                if ( isset( $positionArray[$type] ) )
                    $type = $positionArray[$type];
                else
                    return;

                #eZDebug::writeDebug( $type, 'banner type' );
                $operatorValue = "realmedia( '$type', '$adArea' );";

            } break;
        }
    }
}

?>