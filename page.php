<?php 
get_header();

?>
<div  data-role="page" id="main" >
<div data-role='header'><h1></h1></div>

<div id="content" class="post" data-role="content">


<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

				
                                           <h2>    <?php the_title();?></h2>
                                                    <?php the_content();?>
                                                 
           
				
			

<?php endwhile; // end of the loop. ?>


 

</div>

        
</div> 


		
<?php get_footer(); ?>

 
           


