<?php
    require './connect_db.php';
    if(session_id() == '' || !isset($_SESSION) || session_status() === PHP_SESSION_NONE) {
        session_start();
    } 

    $start = 0;
    $limit_on_page = 4; 
    $offset = 0; 
    
    $sql = "SELECT COUNT(*) FROM announcement";
    if (!$query = mysqli_query($conn, $sql))
        {
            echo'connection_error';
            exit();
        }

    if ($query){
        $result = mysqli_fetch_row($query);
    }else
        $result = 0;
    
    $total_pages = $result[0];
    $total_pages = (int) $total_pages;


    if( isset( $_GET[ 'num_page'] ) ) {

        $taintedStart = $_GET[ 'num_page' ];

        if( strlen( $taintedStart ) <= 2 ) {

            $num_page = intval( $taintedStart );
            
            if( filter_var( $num_page, FILTER_VALIDATE_INT ) ) {

                if( $num_page > $start ) { 
                    $page = $num_page;
                    
                }

            }

        }

    }

    $offset = ( $page * $limit_on_page ) - $limit_on_page;

    if(!$stmt = mysqli_stmt_init($conn)){    
        echo'db_connection_error';  
        exit();
    }

    $sql="SELECT * FROM announcement as ann JOIN boat as bt ON ann.id_boat=bt.id_boat LIMIT ?,?";
    if (!mysqli_stmt_prepare($stmt, $sql))
    {
        echo'dashboard_error'; 
        exit();
    }

    
    if(!mysqli_stmt_bind_param($stmt, "ii", $offset, $limit_on_page)) 
    {
        echo'dashboard_error';    
        exit();
    }

    if (!mysqli_stmt_execute($stmt))
    {
        echo'dashboard_error';
        exit();
    }

    $result = mysqli_stmt_get_result($stmt);

    if ( mysqli_num_rows($result) > 0)
    {
        while($row = mysqli_fetch_assoc($result)){
            echo 
            '<div class="card mb-3"> 
                <div class="row no-gutters">
                    <div class="card-body" style="display: flex; padding-top: 0.5rem !important; padding-bottom: 0.5rem !important;">
                        <div class="col-md-4">
                            <img src= "'.$row['photo_path'].'" class="card-img" alt="...">
                        </div>
                        <div class="col-md-8">
                        
                            <h5 class="card-title">'.htmlspecialchars($row['title']).'</h5>
                            <p class="card-text">'.htmlspecialchars($row['description']).'</p>
    
                        </div>
                    </div>
                </div>
            </div>';
        }
    }

    else
    {
        echo'<h3>Non ci sono annunci presenti!</h3>';
    }

    
    if (ceil($total_pages / $limit_on_page) > 0){
        echo'<ul class="pagination">';
            if ($page > 1){
                echo'<li class="prev"><button class="pagination_ajax" value="'.intval($page-1).'">Prev</button></li>';
            }

            if ($page > 3){
                echo'<li class="start"><button class="pagination_ajax" value="1">1</button></li>
                <li class="dots">...</li>';
            }

            if ($page-2 > 0){ echo'<li class="page"><button class="pagination_ajax" value="'.intval($page-2).'">'.intval($page-2).'</button></li>';}
            if ($page-1 > 0){ echo'<li class="page"><button class="pagination_ajax" value="'.intval($page-1).'">'.intval($page-1).'</button></li>';}

            echo'<li class="currentpage"><button class="pagination_ajax" value="'.$page.'">'.$page.'</button></li>';

            if ($page+1 < ceil($total_pages / $limit_on_page)+1){ echo'<li class="page"><button class="pagination_ajax" value="'.intval($page+1).'">'.intval($page+1).'</button></li>';}
            if ($page+2 < ceil($total_pages / $limit_on_page)+1){ echo'<li class="page"><button class="pagination_ajax" value="'.intval($page+2).'">'.intval($page+2).'</button></li>';}

            if ($page < ceil($total_pages / $limit_on_page)-2){
                echo'li class="dots">...</li>
                <li class="end"><button class="pagination_ajax" value="'.ceil($total_pages / $limit_on_page).'">'.ceil($total_pages / $limit_on_page).'</button></li>';
            }

            if ($page < ceil($total_pages / $limit_on_page)){
                echo '<li class="next"><button class="pagination_ajax" value="'.intval($page+1).'">Next</button></li>';
            }
        echo'</ul>';
    }
    

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    exit(); 