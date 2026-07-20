<?php

function requireAuth(): void {
    if (empty($_SESSION['user_id'])) {
        redirect('login');
        exit;
    }
}
