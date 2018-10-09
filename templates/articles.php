<?php

global $post;
// get all posts with type article to be shared
$articles = get_posts( array( 'post_type' => 'articles' ) );

function get_og_data($url) {
  $site_html=  file_get_contents($url);
    $matches=null;
    preg_match_all('~<\s*meta\s+property="(og:[^"]+)"\s+content="([^"]*)~i',     $site_html,$matches);
    $ogtags=array();
    for($i=0;$i<count($matches[1]);$i++)
    {
        $ogtags[$matches[1][$i]]=$matches[2][$i];
    }
    // echo var_dump($ogtags);
    return $ogtags;
}

// function to shorten og content tag
function substrwords($text, $maxchar, $end='...') {
    if (strlen($text) > $maxchar || $text == '') {
        $words = preg_split('/\s/', $text);
        $output = '';
        $i      = 0;
        while (1) {
            $length = strlen($output)+strlen($words[$i]);
            if ($length > $maxchar) {
                break;
            }
            else {
                $output .= " " . $words[$i];
                ++$i;
            }
        }
        $output .= $end;
    }
    else {
        $output = $text;
    }
    return $output;
}

?>

<section class="articles">
  <h4 class="text-center">Interesting Hebamme Stories</h4>
  <div class="row">
  <?php
    // loop through articles, fetch og tag content, and render
    if( $articles ):
       foreach( $articles as $post ) :
         setup_postdata($post);
         $article_url = get_field( "article_url" );
         $ogtags = get_og_data($article_url); ?>

         <?php if ($ogtags) { ?>
         <div class="article row df">
           <div class="col-md-5">
             <a href="<?php echo $ogtags['og:url']; ?>" target="_blank"><img class="img-responsive" src="<?php echo $ogtags['og:image']; ?>" alt="article image"></a>
            </div>
            <div class="col-md-7">
              <a href="<?php echo $ogtags['og:url']; ?>" target="_blank"><h6><?php echo $ogtags['og:title']; ?></h6></a>
              <aside><?php if ($ogtags['og:site_name']) echo 'von '.$ogtags['og:site_name']; ?></aside>
              <a href="<?php echo $ogtags['og:url']; ?>" target="_blank"><p><?php echo substrwords($ogtags['og:description'], 110); ?></p></a>
            </div>
         </div>
       <?php } ?>

       <?php endforeach;
       wp_reset_postdata();
     endif; ?>
   </div>
</section>
