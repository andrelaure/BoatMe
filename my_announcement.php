<?php
    require "header.php";
    require 'php/connect_db.php';
?>

<section class="" action="./php/my_announcement_ajax.php" >
    <br>
    <div class="width_my_dashboard row">

        <div class="col-2">
            <div class="card" style="border: none">
                <br>
                <h4>Altre opzioni</h4>
                <br>
                <a href="add_announcement.php">
                <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Aggiungi Annuncio</button></a>
                <br>
            </div>
        </div>


        <div class="col-10" id="content">

            <?php

                /// Pagination 

                $limit_on_page = 4; 
                $offset = 0; 
                $page = 1;

                $offset = ( $page * $limit_on_page ) - $limit_on_page;
                
                $sql = "SELECT COUNT(*) FROM announcement WHERE id_user = ".$_SESSION['userId']."";
                if (!$query = mysqli_query($conn, $sql))
                    {
                        header("Location: index.php");
                        exit();
                    } 

                if ($query){
                    $result = mysqli_fetch_row($query);
                }else
                    $result = 0;
                
                $total_pages = $result[0];
                $total_pages = (int) $total_pages;


                /// Query to print announcements

                if(!$stmt = mysqli_stmt_init($conn)){    
                    header("Location: ../my_announcement.php?error=db_connection_error");  
                    exit();
                }

                $sql="SELECT * FROM announcement JOIN boat ON announcement.id_boat = boat.id_boat WHERE announcement.id_user = ".$_SESSION['userId']." LIMIT ?,?";
                if (!mysqli_stmt_prepare($stmt, $sql))
                {
                    header("Location: ../my_announcement.php?error=my_announcement_error");
                    exit();
                }

                if(!mysqli_stmt_bind_param($stmt, "ii", $offset, $limit_on_page))  
                {
                    header("Location: ../my_announcement.php?error=my_announcement_error");
                    exit();
                }

                if (!mysqli_stmt_execute($stmt))
                {
                    header("Location: ../my_announcement.php?error=my_announcement_error");
                    exit();
                }
                

                $result = mysqli_stmt_get_result($stmt);
                if ( mysqli_num_rows($result) > 0)
                {
    
                    while($row = mysqli_fetch_assoc($result)){
                        echo 
                        '<div class="card mb-3">
                            <div class="row no-gutters">
                                <div class="card-body element">
                                    <div class="col-md-4">
                                        <img src= "'.$row['photo_path'].'" class="card-img" alt="...">
                                    </div>
                                    <div class="col-md-8">
                                    
                                        <h5 class="card-title">'.htmlspecialchars($row['title']).'</h5>
                                        <p class="card-text">'.htmlspecialchars($row['description']).'</p>
                                        <form action="./update_announcement.php" class="" method="POST">
                                            <input class="btn btn-outline-primary my-2 my-sm-0" type="submit" value="Modifica Annuncio" />
                                            <input type="hidden" name="id_boat" value=" '.$row['id_boat'].'"/>
                                            <input type="hidden" name="id_ann" value=" '.$row['id_ann'].'"/>
                                        </form>
                                        <br>
                                        <form action="./php/delete_announcement.php" class="trash" method="POST">
                                            <button class="btn btn-outline-danger my-2 my-sm-0" type="submit"><i class="fa fa-trash"> </i> </button>
                                            <input type="hidden" name="id_ann" value=" '.$row['id_ann'].'"/>
                                        </form>
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
                
            ?>
                    
                    <?php if (ceil($total_pages / $limit_on_page) > 0): ?>
                <ul class="pagination">
                    <?php if ($page > 1): ?>
                    <li class="prev"><button type="button" class="pagination_ajax" value="<?php echo $page-1 ?>">Prev</button></li>
                    <?php endif; ?>
    
                    <?php if ($page > 3): ?>
                    <li class="start"><button type="button" class="pagination_ajax" value="1">1</button></li>
                    <li class="dots">...</li>
                    <?php endif; ?>
    
                    <?php if ($page-2 > 0): ?><li class="page"><button type="button" class="pagination_ajax" value="<?php echo $page-2 ?>"><?php echo $page-2 ?></button></li><?php endif; ?>
                    <?php if ($page-1 > 0): ?><li class="page"><button type="button" class="pagination_ajax" value="<?php echo $page-1 ?>"><?php echo $page-1 ?></button></li><?php endif; ?>
    
                    <li class="currentpage"><button type="button" class="pagination_ajax" value="<?php echo $page ?>"><?php echo $page ?></button></li>
    
                    <?php if ($page+1 < ceil($total_pages / $limit_on_page)+1): ?><li class="page"><button type="button" class="pagination_ajax" value="<?php echo $page+1 ?>"><?php echo $page+1 ?></button></li><?php endif; ?>
                    <?php if ($page+2 < ceil($total_pages / $limit_on_page)+1): ?><li class="page"><button type="button" class="pagination_ajax" value="<?php echo $page+2 ?>"><?php echo $page+2 ?></button></li><?php endif; ?>
    
                    <?php if ($page < ceil($total_pages / $limit_on_page)-2): ?>
                    <li class="dots">...</li>
                    <li class="end"><button type="button" class="pagination_ajax" value="<?php echo ceil($total_pages / $limit_on_page) ?>"><?php echo ceil($total_pages / $limit_on_page) ?></button></li>
                    <?php endif; ?>
    
                    <?php if ($page < ceil($total_pages / $limit_on_page)): ?>
                    <li class="next"><button type="button" class="pagination_ajax" value="<?php echo $page+1 ?>">Next</button></li>
                    <?php endif; ?>
                </ul>
                <?php endif; ?> 
                    
              
        </div>

        <script>   
            
            $(document).on("click", ".pagination_ajax",function( e ) {
                e.preventDefault();
                var a = $( this );

                a.addClass( "current" ).
                siblings().
                removeClass( "current" );
                
                var page = a.attr("value");   
                $.get( "./php/my_announcement_ajax.php", { num_page: page }, function( html ) {
                    console.log(html);
                    $( "#content" ).html( html );
                });
            });
                
        </script> 

    </div>
    <?php
    if(session_id() == '' || !isset($_SESSION) || session_status() === PHP_SESSION_NONE) {
        session_start();
    } 
    ?>
</section>

<?php 
    require "footer.php";
?>