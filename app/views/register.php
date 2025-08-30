<?php $title = 'Inscription'; ?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-0 mb-5">
            <div class="card-header bg-primary text-white text-center py-3">
                <h2><i class="fas fa-user-plus me-2"></i>Créer un compte</h2>
            </div>
            <div class="card-body p-4">
                <form action="/register" method="POST">
                    <!-- CSRF Token -->
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
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
                            <div class="form-text">
                                Le nom d'utilisateur doit contenir entre 3 et 50 caractères.
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                <input 
                                    type="email" 
                                    class="form-control <?= isset($_SESSION['errors']['email']) ? 'is-invalid' : '' ?>" 
                                    id="email" 
                                    name="email" 
                                    value="<?= $_SESSION['old']['email'] ?? '' ?>"
                                    required
                                >
                            </div>
                            <?php if (isset($_SESSION['errors']['email'])): ?>
                                <div class="invalid-feedback d-block">
                                    <?= $_SESSION['errors']['email'] ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
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
                            <div class="form-text">
                                Le mot de passe doit contenir au moins 6 caractères.
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="password_confirm" class="form-label">Confirmer le mot de passe</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input 
                                    type="password" 
                                    class="form-control <?= isset($_SESSION['errors']['password_confirm']) ? 'is-invalid' : '' ?>" 
                                    id="password_confirm" 
                                    name="password_confirm" 
                                    required
                                >
                                <button class="btn btn-outline-secondary" type="button" id="togglePasswordConfirm">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <?php if (isset($_SESSION['errors']['password_confirm'])): ?>
                                <div class="invalid-feedback d-block">
                                    <?= $_SESSION['errors']['password_confirm'] ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="terms" name="terms" required>
                            <label class="form-check-label" for="terms">
                                J'accepte les <a href="/terms" class="text-primary">conditions d'utilisation</a> et la <a href="/privacy" class="text-primary">politique de confidentialité</a>
                            </label>
                        </div>
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary py-2">
                            <i class="fas fa-user-plus me-2"></i> S'inscrire
                        </button>
                    </div>
                </form>
            </div>
            <div class="card-footer bg-light text-center py-3">
                <p class="mb-0">Vous avez déjà un compte ? <a href="/login" class="text-primary">Se connecter</a></p>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle password visibility for password field
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
    
    // Toggle password visibility for confirm password field
    const togglePasswordConfirm = document.querySelector('#togglePasswordConfirm');
    const passwordConfirm = document.querySelector('#password_confirm');
    
    togglePasswordConfirm.addEventListener('click', function() {
        // Toggle type attribute
        const type = passwordConfirm.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordConfirm.setAttribute('type', type);
        
        // Toggle icon
        this.querySelector('i').classList.toggle('fa-eye');
        this.querySelector('i').classList.toggle('fa-eye-slash');
    });
});
</script>
