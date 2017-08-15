<?php

namespace Vendi\LCT;

use Sunra\PhpSimple\HtmlDomParser;

class cleaner extends \WP_CLI_Command
{

    public function strip_div()
    {
        $args = [
                    'posts_per_page'   => -1,
                    'post_type'        => 'post',
                    'post_status'      => 'publish',
                    'suppress_filters' => true ,
        ];

        $posts = get_posts( $args );

        foreach( $posts as $post )
        {
            $before = $post->post_content;

            while( true )
            {
                $after = preg_replace(
                                        '/' .
                                        preg_quote( '<div>', '/' ) .
                                        '(.*?)' .
                                        preg_quote( '</div>', '/' ) .
                                        '/',
                                        '$1',
                                        $before
                                    );

                if( $before === $after )
                {
                    break;
                }

                echo sprintf( 'Updating post %1$s', $post->ID ) . "\n";

                wp_update_post(
                                [
                                  'ID'           => $post->ID,
                                  'post_content' => $after,
                                ]
                );

                $before = $after;
            }
        }
    }

    public function clean()
    {
        $args = [
                    'posts_per_page'   => -1,
                    'post_type'        => 'post',
                    'post_status'      => 'publish',
                    'suppress_filters' => true ,
        ];

        $posts = get_posts( $args );

        foreach( $posts as $post )
        {
            if( ! preg_match( '/style\s*=\s*[\'"]/', $post->post_content ) )
            {
                continue;
            }

            $before = $post->post_content;

            $dom = HtmlDomParser::str_get_html( $post->post_content );

            foreach( $dom->find( '*[style]' ) as $e )
            {
                $e->style = null;
            }

            $dom->load( $dom->save() );
            $after = $dom->save();

            $after_2 = str_replace( '<span>', '', $after );
            $after_2 = str_replace( '</span>', '', $after_2 );

            $after_3 = \Patchwork\Utf8::toAscii( $after_2, '' );

            if( $before !== $after_3 )
            {
                echo sprintf( 'Updating post %1$s', $post->ID ) . "\n";

                wp_update_post(
                                [
                                  'ID'           => $post->ID,
                                  'post_content' => $after_3,
                                ]
                );
            }
        }
    }
}
