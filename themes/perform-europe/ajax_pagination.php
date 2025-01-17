<?php 

$prev = $page - 1;

$next = $page + 1;

$lastpage = ceil($count/$recordsPerPage);

$lpm1 = $lastpage - 1;   

$pagination = "";

if($lastpage > 1){   

    $pagination .= "<div class='search__pages__pages'>";

    if ($page > 1){

      //$pagination.= "<div p='".$prev."' class='active_cell search__page__link'><a href='javascript:;' p='".$prev."'>&laquo;</a></div>";

	  }

    if ($lastpage < 3 + ($adjacents * 4))
    {   
      for ($counter = 1; $counter <= $lastpage; $counter++) {

        if ($counter == $page)

          $pagination.= "<div class='search__page__link page--current'><span>$counter</span></div>";

        else

          $pagination.= "<div p='".$counter."' class='active_cell search__page__link'><a href='javascript:;'>$counter</a></div>";     
      }
    }

    elseif($lastpage > 1 + ($adjacents * 2)){

      if($page < 1 + ($adjacents * 2))
      {
        for($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
        {
          if($counter == $page)

            $pagination.= "<div class='search__page__link page--current'><span >$counter</span></div>";

          else

              $pagination.= "<div p='".$counter."' class='active_cell search__page__link'><a href='javascript:;' >$counter</a></div>";     

        }

        //$pagination.= "<div class='dismiss'><a href='javascript:;'>...</a></div>";

        $pagination.= "<div p='".$lpm1."' class='active_cell search__page__link'><a href='javascript:;' >$lpm1</a></div>";
      }

      elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
      {

        $pagination.= "<div p='1' class='active_cell search__page__link'><a href='javascript:;'>1</a></div>";

        $pagination.= "<div class='dismiss'><a href='javascript:;'>...</a></div>";

        for($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
        {
            
          if($counter == $page)

             $pagination.= "<div class='search__page__link page--current'><span >$counter</span></div>";

          else

            $pagination.= "<div  p='".$counter."' class='active_cell search__page__link'><a href='javascript:;'>$counter</a></div>";     

        }

        $pagination.= "<div class='dismiss'><a href='javascript:;'>...</a></div>";

       // $pagination.= "<div  p='".$lpm1."' class='active_cell search__page__link'><a href='javascript:;'>$lpm1</a></div>";

      }

      else
      {

        $pagination.= "<div p='1' class='active_cell search__page__link'><a href='javascript:;'>1</a></div>";

        $pagination.= "<div class='dismiss'><a href='javascript:;'>...</a></div>";

        for($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) 
        {

          if($counter == $page)

            $pagination.= "<div class='search__page__link page--current'><span>$counter</span></div>";

          else

            $pagination.= "<div p='".$counter."' class='active_cell search__page__link'><a href='javascript:;' >$counter</a><div>";     

        }

      }

    }

    if($page < $counter - 1)
		{
      //$pagination.= "<div p='".$next."' class='active_cell search__page__link'><a href='javascript:;' p='".$next."'>&raquo;</a></div>";
		}
    
    $pagination.= "</div>";       

  }

	echo $pagination;