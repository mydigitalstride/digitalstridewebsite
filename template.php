<?php
/**
 * Template Name: Flexible Content
 */

get_header();

if ( have_rows('home_page_section') ):
    while ( have_rows('home_page_section') ) : the_row();

        if ( get_row_layout() == 'hero_section' ):
            get_template_part('template-parts/section', 'hero');

        elseif ( get_row_layout() == 'section_header' ):
            get_template_part('template-parts/section', 'header');

        elseif ( get_row_layout() == 'bubbles_section' ):
            get_template_part('template-parts/section', 'bubble');

        elseif ( get_row_layout() == 'marketing_section' ):
            get_template_part('template-parts/section', 'marketing');

        elseif ( get_row_layout() == 'growth_section' ):
            get_template_part('template-parts/section', 'left');

        elseif ( get_row_layout() == 'section_subheader' ):
            get_template_part('template-parts/section', 'subheader');

        elseif ( get_row_layout() == 'bubbles_section' || get_row_layout() == 'bubbles_section_copy' ):
            get_template_part('template-parts/section', 'bubbles');

        elseif ( get_row_layout() == 'marketing_section' ):
            get_template_part('template-parts/section', 'marketing');

        elseif ( get_row_layout() == 'we_also_do_section' ):
            get_template_part('template-parts/section', 'we-also-do');

        elseif ( get_row_layout() == 'plus_banner' ):
            get_template_part('template-parts/section', 'banner');
        elseif (get_row_layout() == 'bubbles_image_section'):
        get_template_part('template-parts/section', 'centered-bubbles');
        elseif ( get_row_layout() == 'client_spotlight_section' ):
            get_template_part('template-parts/section', 'spotlight');
        elseif ( get_row_layout() == 'blue_bubble' ):
            get_template_part('template-parts/section', 'bluebubbles');
        elseif ( get_row_layout() == 'word_image_section' ):
            get_template_part('template-parts/section', 'wordimage');
        elseif ( get_row_layout() == 'error_404_block' ):
            get_template_part('template-parts/section', '404');
            elseif ( get_row_layout() == 'contact_section' ):
            get_template_part('template-parts/section', 'contact');
                elseif ( get_row_layout() == 'scrolling_sidebar' ):
            get_template_part('template-parts/section', 'scrollbar'); 
                elseif ( get_row_layout() == 'resource_listing' ):
            get_template_part('template-parts/section', 'resourcelisting'); 
              elseif ( get_row_layout() == 'resource_cards' ):
            get_template_part('template-parts/section', 'resourcecard');
               elseif ( get_row_layout() == 'peach_banner' ):
            get_template_part('template-parts/section', 'peachbanner');
                elseif ( get_row_layout() == 'values_section' ):
            get_template_part('template-parts/section', 'core');
            elseif ( get_row_layout() == 'mission_section' ):
            get_template_part('template-parts/section', 'mission');
             elseif ( get_row_layout() == 'strategy' ):
            get_template_part('template-parts/section', 'strategy');
                 elseif ( get_row_layout() == 'mindset' ):
            get_template_part('template-parts/section', 'mindset');
                 elseif ( get_row_layout() == 'our_team_section' ):
            get_template_part('template-parts/section', 'team-members');
              elseif ( get_row_layout() == 'our_fur_section' ):
            get_template_part('template-parts/section', 'our-fur');
             elseif ( get_row_layout() == 'call_to_action_section' ):
            get_template_part('template-parts/section', 'call-to-action');
        elseif (get_row_layout() == 'x_image'):
            get_template_part('template-parts/section', 'core-and-mission-wrapped');
             elseif (get_row_layout() == 'we_also_do_section'):
            get_template_part('template-parts/section', 'we-also-do');
        endif;
    endwhile;
endif;

get_footer();
