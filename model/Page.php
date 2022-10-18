<?php

namespace nmvcsite\model;

class Page
{
    public function loadNavBar()
    {
        $sessionsLi = "";
        if(isset($_SESSION['user_data']) and $_SESSION['user_data']) {
            $sessionsLi = '
                <li class="nav-item">
                    <a class="nav-link" href="' . BASE_URL . 'profile">' . __('Profile') . '</a>
                </li>';
            if($_SESSION['user_data']['opportunity']['addComments'] == 1) {
                $sessionsLi .= '
                    <li class="nav-item">
                        <a class="nav-link" href="' . BASE_URL . 'messages/add">' . __('Add') . '</a>
                    </li>';
            }
            if($_SESSION['user_data']['opportunity']['promoteUser'] == 1) {
                $sessionsLi .= '
                    <li class="nav-item">
                        <a class="nav-link" href="' . BASE_URL . 'promotions">' . __('Promotions') . '</a>
                    </li>
                    <li>
                        <a class="nav-link" href="' . BASE_URL . 'opportunity">' . __('Oportunity') . '</a>
                    </li>';
            }
            if($_SESSION['user_data']['role'] == 1) {
                $sessionsLi .= '
                    <li>
                        <a class="nav-link" href="' . BASE_URL . 'cli">' . __('Cli') . '</a>
                    </li>';
            }

        }

        return '<li class="nav-item">
                    <a class="nav-link" href="' . BASE_URL . '">' . __('Home') . '</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="' . BASE_URL . 'contacts">' . __('Contacts') . '</a>
                </li>' . $sessionsLi;

    }
}