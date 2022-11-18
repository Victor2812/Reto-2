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
                        $user = $GLOBALS['session']->getCurrentUser();
                        foreach (UserRepository::getFollowingInfo($user) as $following) {
                             echo "<li><div class='icon'></div>".$following->getUsername()."</li>";
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
                        foreach (UserRepository::getFollowersInfo($user) as $follower) {
                            echo "<li><div class='icon'></div>".$follower->getUsername()."</li>";
                        }
                    ?>
                </ul>
            </div>
        </div>
    </div>
</aside>