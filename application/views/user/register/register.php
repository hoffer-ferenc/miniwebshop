<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container">
    <div class="row">
        <?php if (validation_errors()) : ?>
            <div class="col-md-12">
                <div class="alert alert-danger" role="alert">
                    <?= validation_errors() ?>
                </div>
            </div>
        <?php endif; ?>
        <?php if (isset($error)) : ?>
            <div class="col-md-12">
                <div class="alert alert-danger" role="alert">
                    <?= $error ?>
                </div>
            </div>
        <?php endif; ?>
        <div class="col-md-12">
            <div class="page-header">
                <h1>Regisztráció</h1>
            </div>
            <?= form_open() ?>
                    <div class="form-group">
                        <label for="username">Felhasználónév</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Felhasználónév">
                        <p class="help-block">Legalább 4 karakter, betű vagy szám engedélyezett csak.</p>
                    </div>
                    <div class="form-group">
                        <label for="email">Email cím</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email címe">
                        <p class="help-block">Létező email címnek kell lennie.</p>
                    </div>
                    <div class="form-group">
                        <label for="password">Jelszó</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Jelszava">
                        <p class="help-block">Minimum 6 karakter</p>
                    </div>
                    <div class="form-group">
                        <label for="password_confirm">Jelszó mégegyszer</label>
                        <input type="password" class="form-control" id="password_confirm" name="password_confirm" placeholder="Írja be jelszavát újra">
                        <p class="help-block">A két jelszónak egyeznie kell.</p>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-default" value="Regisztráció">
                    </div>
            </form>
        </div>
    </div><!-- .row -->
</div><!-- .container -->