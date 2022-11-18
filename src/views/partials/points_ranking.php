<div class="ranking">
    <div class="title">RANKING</div>
        <div class="user_points">
            <ul>
                <?php 
                    foreach (UserRepository::getRankingInfo() as $ranking) {
                        echo "<li class='position'>
                            <div>".$ranking->getPoints()."</div>
                            <div>".$ranking->getUserName()."</div>
                            <div>".$ranking->getJob()."</div>
                        </li>";
                    }                    
                ?>
            </ul>
        </div>
</div>