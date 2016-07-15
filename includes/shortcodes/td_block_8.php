<?php
class td_block_8 extends td_block {
    function render($atts, $content = null) {
        parent::render($atts); // sets the live atts, $this->atts, $this->block_uid, $this->td_query (it runs the query)

        if (empty($td_column_number)) {
            $td_column_number = td_util::vc_get_column_number(); // get the column width of the block from the page builder API
        }

        $buffy = ''; //output buffer

        $buffy .= '<div class="' . $this->get_block_classes() . '" ' . $this->get_block_html_atts() . '>';

        //get the block js
        $buffy .= $this->get_block_css();

        //get the js for this block
        $buffy .= $this->get_block_js();

        $buffy .= '<div class="td-block-header">';

        //get the block title
        $buffy .= $this->get_block_title();

        //get the sub category filter for this block
        $buffy .= $this->get_pull_down_filter();

        $buffy .= '</div>'; // /.td-block-header

        $buffy .= '<div id=' . $this->block_uid . ' class="td_block_inner td-column-' . $td_column_number . '">';
        $buffy .= $this->inner($this->td_query->posts);  //inner content of the block
        $buffy .= '</div>';

        //get the ajax pagination for this block
        $buffy .= $this->get_block_pagination();
        $buffy .= '</div> <!-- ./block -->';
        return $buffy;
    }

    function inner($posts, $td_column_number = '') {
        $buffy = '';

        $td_block_layout = new td_block_layout();
        if (empty($td_column_number)) {
            $td_column_number = td_util::vc_get_column_number(); // get the column width of the block from the page builder API
        }

        $td_post_count = 0; // the number of posts rendered
        $td_current_column = 1; //the current column

        if (!empty($posts)) {
            foreach ($posts as $post) {
                $td_module_4 = new td_module_4($post);
                $td_module_5 = new td_module_5($post);
                $td_module_2 = new td_module_2($post);

                switch ($td_column_number) {

                    case '1': //one column layout
                        if ($td_post_count == 0) { //first post
                            $buffy .= $td_module_4->render();
                        } else {
                            $buffy .= $td_module_2->render();
                        }
                        break;

                    case '2': //two column layout
                        if ($td_post_count == 0) { //first post
                            $buffy .= $td_module_4->render();
                        } else {
                            $buffy .= $td_module_5->render();
                        }
                        break;

                    case '3': //three column layout
                        if ($td_post_count == 0) { //first post
                            $buffy .= $td_module_4->render();
                            $td_current_column = 1;
                        } else {
                            $buffy .= $td_block_layout->open_row();

                            $buffy .= $td_block_layout->open6();
                            $buffy .= $td_module_5->render();
                            $buffy .= $td_block_layout->close6();

                            if ($td_current_column == 3) {
                                $buffy .= $td_block_layout->close_row();
                            }
                        }

                        break;
                }

                //current column
                if ($td_current_column == $td_column_number) {
                    $td_current_column = 1;
                } else {
                    $td_current_column++;
                }

                $td_post_count++;
            }
        }
        $buffy .= $td_block_layout->close_all_tags();
        return $buffy;
    }
}