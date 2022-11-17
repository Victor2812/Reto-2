<aside class="sidebar-right">
    <div class="right_container">
        <div class="aside_div">
            <div class="title">PUNTOS</div>
            <div class="points"><?php echo $GLOBALS['session']->getCurrentUser()->getPoints() ?></div>
        </div>
        <div class="aside_div">
            <div class="title">SEGUIDOS</div>
            <div class="user_list">
                <ul>
                    <?php 
                        $user =  $GLOBALS['session']->getCurrentUser();
                        $following_data = UserRepository::getFollowingInfo($user);
                        foreach ($following_data as $following) {
                            $seguidos = $following->getUsername();  
                            echo "<li><div class='icon'></div>".$seguidos."</li>";                      
                        }
                    ?>
                </ul>
            </div>
        </div>
        <div class="aside_div">
            <div class="title">SEGUIDORES</div>
            <div class="user_list">
                <ul>
                    <?php 
                        $user = $GLOBALS['session']->getCurrentUser();
                        $follower_data = UserRepository::getFollowersInfo($user);
                        foreach ($follower_data as $follower) {
                            $seguidor = $follower->getUsername();
                            echo "<li><div class='icon'></div>".$seguidor."</li>";
                        }
                    ?>
                </ul>
            </div>
        </div>
    </div>
</aside>