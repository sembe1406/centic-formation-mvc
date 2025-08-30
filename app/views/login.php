<?php $title = 'Connexion'; ?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm border-0 mb-5">
            <div class="card-header bg-primary text-white text-center py-3">
                <h2><i class="fas fa-sign-in-alt me-2"></i>Connexion</h2>
            </div>
            <div class="card-body p-4">
                <?php if (isset($_SESSION['errors']['auth'])): ?>
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle me-2"></i> <?= $_SESSION['errors']['auth'] ?>
                    </div>
                <?php endif; ?>

                <form action="/login" method="POST">
                    <!-- CSRF Token -->
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
                    
                    <div class="mb-3">
                        <label for="username" class="form-label">Nom d'utilisateur</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                            <input 
                                type="text" 
                                class="form-control <?= isset($_SESSION['errors']['username']) ? 'is-invalid' : '' ?>" 
                                id="username" 
                                name="username" 
                                value="<?= $_SESSION['old']['username'] ?? '' ?>"
                                required
                                autofocus
                            >
                        </div>
                        <?php if (isset($_SESSION['errors']['username'])): ?>
                            <div class="invalid-feedback d-block">
                                <?= $_SESSION['errors']['username'] ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="mb-3">
                        <label for="password" class="form-label">Mot de passe</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input 
                                type="password" 
                                class="form-control <?= isset($_SESSION['errors']['password']) ? 'is-invalid' : '' ?>" 
                                id="password" 
                                name="password" 
                                required
                            >
                            <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <?php if (isset($_SESSION['errors']['password'])): ?>
                            <div class="invalid-feedback d-block">
                                <?= $_SESSION['errors']['password'] ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary py-2">
                            <i class="fas fa-sign-in-alt me-2"></i> Se connecter
                        </button>
                    </div>
                </form>
            </div>
            <div class="card-footer bg-light text-center py-3">
                <p class="mb-0">Vous n'avez pas de compte ? <a href="/register" class="text-primary">Créer un compte</a></p>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');
    
    togglePassword.addEventListener('click', function() {
        // Toggle type attribute
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        
        // Toggle icon
        this.querySelector('i').classList.toggle('fa-eye');
        this.querySelector('i').classList.toggle('fa-eye-slash');
    });
});
</script>
