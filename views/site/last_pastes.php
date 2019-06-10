<div class="col-md-4 col-md-offset-2">
    <h2>Последние пасты</h2>
    <form>
        <div class="form-group" >
            <ul class="list-group">
                <?php if($public_href_pastes) : foreach ($public_href_pastes as $public_href_paste) :?>
                    <li class="list-group-item"><a href="/<?php echo $public_href_paste['url']; ?>" ><?php echo $public_href_paste['short_title']; ?></a></li>
                <?php endforeach; endif;?>
            </ul>
        </div>
    </form>
</div>