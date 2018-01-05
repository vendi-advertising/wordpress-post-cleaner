<?php

namespace Vendi\WordPressPostCleaner;

use Sunra\PhpSimple\HtmlDomParser;

class cleaner extends \WP_CLI_Command
{

    public function clean()
    {
        $args = [
                    'posts_per_page'   => -1,
                    'post_type'        => [ 'page'],
                    'post_status'      => 'publish',
                    'suppress_filters' => true ,
        ];

        $posts = get_posts( $args );

        foreach( $posts as $post )
        {
            if( ! preg_match( '/[id|style|data-canvas-width|dir]\s*=\s*[\'"]/', $post->post_content ) )
            {
                continue;
            }

            if( ! $post->post_content )
            {
                continue;
            }

            // if( (int)$post->ID !== 1688 )
            // {
            //     continue;
            // }

            // dump( $post->post_content );
            // die;


            $before = $post->post_content;

            $dom = HtmlDomParser::str_get_html( $post->post_content );

            foreach( [ 'id', 'style', 'data-canvas-width', 'dir' ] as $attribute )
            {
                foreach( $dom->find( '*[' . $attribute . ']' ) as $e )
                {
                    $e->$attribute = null;
                }
            }

            $dom->load( $dom->save() );
            $after = $dom->save();

            $after_2 = str_replace( '<span>', '', $after );
            $after_2 = str_replace( '</span>', '', $after_2 );
            $after_2 = str_replace( '<div>', '', $after );
            $after_2 = str_replace( '</div>', '', $after_2 );

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
