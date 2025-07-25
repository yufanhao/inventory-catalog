<?php
// Common file to add table pagination. 
// TODO: explain how the pages are displayed
// TODO: explain usage by calling code.
    require_once('../db.php');
?>

<html>
        <style>
            .pagination {
                list-style-type: none;
                padding: 10px 0;
                display: inline-flex;
                justify-content: space-between;
                box-sizing: border-box;
            }
            .pagination li {
                box-sizing: border-box;
                padding-right: 10px;
            }
            .pagination li a {
                box-sizing: border-box;
                background-color: #e2e6e6;
                padding: 8px;
                text-decoration: none;
                font-size: 12px;
                font-weight: bold;
                color: #616872;
                border-radius: 4px;
            }
            .pagination li a:hover {
                background-color: #d4dada;
            }
            .pagination .next a, .pagination .prev a {
                text-transform: uppercase;
                font-size: 12px;
            }
            .pagination .currentpage a {
                background-color: #518acb;
                color: #fff;
            }
            .pagination .currentpage a:hover {
                background-color: #518acb;
            }
        </style>

<?php
    //Pagination: Initialize Variables
    function initialize_pagination($conn, $sql, $num_rows_per_page = 5) {
        //echo $sql;
        $row_count = $conn->query($sql)->num_rows;
        $num_of_pages = ceil($row_count / $num_rows_per_page);
        //echo $num_of_pages;
        $page = isset($_GET["page"]) && isset($_GET["page"]) !== '' ? $_GET["page"] : 1; 
        $starting_row = ($page - 1) * $num_rows_per_page;

        $ret_val = array( 
            "page" => $page,
            "num_of_pages" => $num_of_pages,
            "pagination_limit" => " LIMIT $starting_row, $num_rows_per_page"
        );
        return $ret_val;
    }

    // Pagination: Display section, using styles defined at the top of the page.  

    function display_pagination($pagination_context, $url_base, $url_params) {
        $target=$url_base."?". http_build_query(array_filter($url_params));
        $page = $pagination_context["page"];
        $num_of_pages = $pagination_context["num_of_pages"];

        echo '<div>';
        if ($num_of_pages > 0) {
            echo '<ul class="pagination">';
                if ($page > 1) {
                    echo '<li class="prev"><a href="' . $target . '&page=' . ($page-1) . '">Prev</a></li>';
                }
                
                if ($page > 3) {
                    echo '<li class="start"><a href="' . $target . '&page=' . 1 . '">' . 1 . '</a></li>';
                    echo '<li class="dots">...</li>';
                }

                if ($page-2 > 0)  {
                    echo '<li class="page"><a href="' . $target . '&page=' . ($page-2) . '">' . ($page-2) . '</a></li>';
                }

                if ($page-1 > 0) {
                    echo '<li class="page"><a href="' . $target . '&page=' . ($page-1) . '">' . ($page-1) . '</a></li>';
                }
                
                echo '<li class="currentpage"><a href="' . $target . '&page=' . $page . '">' . $page . '</a></li>';

                if ($page+1 < $num_of_pages + 1) {
                    echo '<li class="page"><a href="' . $target . '&page=' . ($page+1) . '">' . ($page+1) . '</a></li>';
                }
                if (($page+2) < ($num_of_pages + 1)) {
                    echo '<li class="page"><a href="' . $target . '&page=' . ($page+2) . '">' . ($page+2) . '</a></li>';
                }
                
                if ($page < ($num_of_pages - 2)) {
                    echo '<li class="dots">...</li>';
                    echo '<li class="end"><a href="' . $target . '&page=' . $num_of_pages. '">' . $num_of_pages . '</a></li>';
                }

                if ($page < $num_of_pages ) {
                    echo '<li class="next"><a href="'. $target . '&page=' . ($page+1) . '">Next</a></li>';
                }
            echo '</ul>';
        }
        echo '</div>';

    }

?>
</html>