<?php

namespace nmvcsite\model;

class Page
{
    public function loadNavBar()
    {
        if(isset($_SESSION['user_data']) and $_SESSION['user_data']) {
            $sessionsLi = '';
        }

        return '<li class="nav-item">
                    <a class="nav-link" href="' . BASE_URL . '">' . __('Home') . '</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="' . BASE_URL . 'contacts">' . __('Contacts') . '</a>
                </li>';

    }
}