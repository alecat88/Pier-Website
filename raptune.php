<?php
/*
Template Name: Raptune
*/


//use nusoap library: http://sourceforge.net/projects/nusoap/ 
//tested with php 5, nusoap version 0.9.5 
require_once('lib/nusoap.php'); 

//NOTE: both parameters and values are case sensitve! 
//NOTE: the internal php class SoapClient does not work with named parameters and SOAP headers 

//prepare soap request to Rapaport: 
$rap_soapUrl = "https://technet.rapaport.com/webservices/prices/rapaportprices.asmx?wsdl"; 
$soap_Client = new nusoap_client($rap_soapUrl, 'wsdl'); 
$rap_credentials['Username'] = "73923"; 
$rap_credentials['Password'] = "villamarts"; 

//do login, and save authentication ticket for further use: 
$result = $soap_Client->call('Login', $rap_credentials); 
$rap_auth_ticket = $soap_Client->getHeaders(); 

//get complete price sheet, and save as a file (call this both for Round and Pear): 
$paramsB["shape"] = "Round"; 
$soap_Client->setHeaders($rap_auth_ticket); 
$result = $soap_Client->call('GetPriceSheet', $paramsB); 

$file=fopen("c:\\temp\\round_prices.csv","w+") or exit("Unable to open file!"); 

for ($i=0; $i { 


$curLine .= $result['GetPriceSheetResult']['!Date']; 
$curLine .= "," . $result['GetPriceSheetResult']['!Shape']; 
$curLine .= "," . $result['GetPriceSheetResult']['Prices']['diffgram']['NewDataSet']['Table'][$i]['LowSize']; 
$curLine .= "," . $result['GetPriceSheetResult']['Prices']['diffgram']['NewDataSet']['Table'][$i]['LowSize']; 
$curLine .= "," . $result['GetPriceSheetResult']['Prices']['diffgram']['NewDataSet']['Table'][$i]['Color']; 
$curLine .= "," . $result['GetPriceSheetResult']['Prices']['diffgram']['NewDataSet']['Table'][$i]['Clarity']; 
$curLine .= "," . $result['GetPriceSheetResult']['Prices']['diffgram']['NewDataSet']['Table'][$i]['Price']; 

fwrite($file, $curLine.PHP_EOL); 
} 

fclose($file); 

?> 
<?php

get_header();

$is_page_builder_used = et_pb_is_pagebuilder_used( get_the_ID() );

?>

<div id="main-content">

<?php if ( ! $is_page_builder_used ) : ?>

	<div class="container">
		<div id="content-area" class="clearfix">
			<div id="left-area">

<?php endif; ?>

			<?php while ( have_posts() ) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

				<?php if ( ! $is_page_builder_used ) : ?>

					<h1 class="entry-title main_title"><?php the_title(); ?></h1>
				<?php
					$thumb = '';

					$width = (int) apply_filters( 'et_pb_index_blog_image_width', 1080 );

					$height = (int) apply_filters( 'et_pb_index_blog_image_height', 675 );
					$classtext = 'et_featured_image';
					$titletext = get_the_title();
					$thumbnail = get_thumbnail( $width, $height, $classtext, $titletext, $titletext, false, 'Blogimage' );
					$thumb = $thumbnail["thumb"];

					if ( 'on' === et_get_option( 'divi_page_thumbnails', 'false' ) && '' !== $thumb )
						print_thumbnail( $thumb, $thumbnail["use_timthumb"], $titletext, $width, $height );
				?>

				<?php endif; ?>

					<div class="entry-content">
					<?php
						the_content();

						if ( ! $is_page_builder_used )
							wp_link_pages( array( 'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'Divi' ), 'after' => '</div>' ) );
					?>
					</div> <!-- .entry-content -->

				<?php
					if ( ! $is_page_builder_used && comments_open() && 'on' === et_get_option( 'divi_show_pagescomments', 'false' ) ) comments_template( '', true );
				?>

				</article> <!-- .et_pb_post -->

			<?php endwhile; ?>

<?php if ( ! $is_page_builder_used ) : ?>

			</div> <!-- #left-area -->

			<?php get_sidebar(); ?>
		</div> <!-- #content-area -->
	</div> <!-- .container -->

<?php endif; ?>

</div> <!-- #main-content -->

<?php get_footer(); ?>