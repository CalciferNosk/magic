<?php 

foreach ($response as $comment) :
    if ($comment->createdBy == $_SESSION['systemAccessId']) :  #if the id is squal to session will give different design  ?>
        <div class="d-flex align-items-baseline text-end justify-content-end mb-4">
            <div class="pe-2 pr-2" style="width: 70%;">
                <div class="card card-text d-inline-block p-2 pull-right" style="width:auto ;min-width:25%  ;max-width:120%; background-color:#0046d40f;border:1px solid #80808024" align="right">
                    <?= $comment->comments ?>
                </div>
                <br>
                <br>
                <div>
                    <div class="small pull-right" style="font-size: 60% !important;"> <b><?= $comment->sender ?> &#x2022;</b> <span style="color:#acb8b8"><?= $comment->timestamp ?></span></div>
                </div>
            </div>
        </div>
    <?php else :  ?>
        <div class="d-flex align-items-baseline ">
            <div class="pe-2 ">

                <div class="card card-text d-inline-block  p-2 " style="width:auto; min-width:25%;max-width:120%;background-color:#cacaca1a;border:1px solid #80808024" align="left">
                    <?= $comment->comments ?>
                 
                </div>
                <div>
                    <div class="small pl-2" style="font-size: 60% !important;"> <b><?= $comment->sender ?> &#x2022; </b> <span style="color:#acb8b8"><?= $comment->timestamp ?></span></div>
                </div>
            </div>
        </div>
<?php  endif;
endforeach; ?>