<!-- Hero Section -->
<section class="hero" id="accueil">
    <div class="hero-content">
        <h2><?php echo $site_slogan; ?></h2>
        <p>Des milliers d'annonces immobilières vérifiées</p>

        <form class="search-form" method="GET" action="search.php">
            <div class="search-grid">
                <div class="form-group">
                    <label for="transaction">Transaction</label>
                    <select id="transaction" name="transaction">
                        <option value="">Toutes</option>
                        <option value="vente">Achat</option>
                        <option value="location">Location</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="type">Type de bien</label>
                    <select id="type" name="type">
                        <option value="">Tous</option>
                        <option value="appartement">Appartement</option>
                        <option value="maison">Maison</option>
                        <option value="studio">Studio</option>
                        <option value="terrain">Terrain</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="location">Ville</label>
                    <input type="text" id="location" name="location" placeholder="Paris, Lyon, Marseille...">
                </div>
                <div class="form-group">
                    <label for="budget">Budget max</label>
                    <select id="budget" name="budget">
                        <option value="">Aucune limite</option>
                        <option value="200000">200 000 €</option>
                        <option value="400000">400 000 €</option>
                        <option value="600000">600 000 €</option>
                        <option value="800000">800 000 €</option>
                        <option value="1000000">1 000 000 €</option>
                    </select>
                </div>
            </div>
            <button type="submit" class="search-btn">
                <i class="fas fa-search"></i> Rechercher
            </button>
        </form>
    </div>
</section>

<!-- Stats Section -->
<section class="stats">
    <div class="container">
        <div class="stats-grid">
            <div class="stat-item">
                <div class="stat-number"><?php echo number_format($stats['total_properties'], 0, ',', ' '); ?></div>
                <div class="stat-label">Biens disponibles</div>
            </div>
            <div class="stat-item">
                <div class="stat-number"><?php echo $stats['cities']; ?>+</div>
                <div class="stat-label">Villes couvertes</div>
            </div>
            <div class="stat-item">
                <div class="stat-number"><?php echo number_format($stats['satisfied_clients'], 0, ',', ' '); ?>+</div>
                <div class="stat-label">Clients satisfaits</div>
            </div>
        </div>
    </div>
</section>

<!-- Maisons en vedette -->
<section class="featured">
    <div class="container">
        <h2 class="section-title">Maisons en vedette</h2>
        <div class="properties-grid">
            <?php foreach ($maisons as $maison): ?>
                <div class="property-card">
                    <div class="property-image" style="background-image: url('<?php echo $maison['image']; ?>')">
                        <span class="property-type">Maison</span>
                    </div>
                    <div class="property-details">
                        <h3 class="property-title"><?php echo $maison['title']; ?></h3>
                        <div class="property-price"><?php echo number_format($maison['price'], 0, ',', ' '); ?> €</div>
                        <div class="property-location">
                            <i class="fas fa-map-marker-alt"></i>
                            <?php echo $maison['location']; ?>
                        </div>
                        <p class="property-description"><?php echo $maison['description']; ?></p>
                        <div class="property-features">
                            <div class="feature">
                                <i class="fas fa-expand-arrows-alt"></i>
                                <?php echo $maison['surface']; ?> m²
                            </div>
                            <div class="feature">
                                <i class="fas fa-bed"></i>
                                <?php echo $maison['bedrooms']; ?> ch.
                            </div>
                            <div class="feature">
                                <i class="fas fa-bath"></i>
                                <?php echo $maison['bathrooms']; ?> sdb
                            </div>
                        </div>
                        <div class="property-extras">
                            <?php if ($maison['garage']): ?>
                                <span class="extra-item"><i class="fas fa-car"></i> Garage</span>
                            <?php endif; ?>
                            <?php if ($maison['garden']): ?>
                                <span class="extra-item"><i class="fas fa-seedling"></i> Jardin</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Appartements en vedette -->
<section class="featured apartments">
    <div class="container">
        <h2 class="section-title">Appartements en vedette</h2>
        <div class="properties-grid">
            <?php foreach ($appartements as $appartement): ?>
                <div class="property-card">
                    <div class="property-image" style="background-image: url('<?php echo $appartement['image']; ?>')">
                        <span class="property-type">Appartement</span>
                    </div>
                    <div class="property-details">
                        <h3 class="property-title"><?php echo $appartement['title']; ?></h3>
                        <div class="property-price"><?php echo number_format($appartement['price'], 0, ',', ' '); ?> €</div>
                        <div class="property-location">
                            <i class="fas fa-map-marker-alt"></i>
                            <?php echo $appartement['location']; ?>
                        </div>
                        <p class="property-description"><?php echo $appartement['description']; ?></p>
                        <div class="property-features">
                            <div class="feature">
                                <i class="fas fa-expand-arrows-alt"></i>
                                <?php echo $appartement['surface']; ?> m²
                            </div>
                            <?php if ($appartement['bedrooms'] > 0): ?>
                                <div class="feature">
                                    <i class="fas fa-bed"></i>
                                    <?php echo $appartement['bedrooms']; ?> ch.
                                </div>
                            <?php endif; ?>
                            <div class="feature">
                                <i class="fas fa-bath"></i>
                                <?php echo $appartement['bathrooms']; ?> sdb
                            </div>
                        </div>
                        <div class="property-extras">
                            <?php if ($appartement['balcon']): ?>
                                <span class="extra-item"><i class="fas fa-tree"></i> Balcon</span>
                            <?php endif; ?>
                            <?php if ($appartement['ascenseur']): ?>
                                <span class="extra-item"><i class="fas fa-arrow-up"></i> Ascenseur</span>
                            <?php endif; ?>
                            <?php if ($appartement['parking']): ?>
                                <span class="extra-item"><i class="fas fa-car"></i> Parking</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Services Section -->
<section class="services">
    <div class="container">
        <h2 class="section-title">Nos services</h2>
        <div class="services-grid">
            <div class="service-card">
                <div class="service-icon">
                    <i class="fas fa-search"></i>
                </div>
                <h3 class="service-title">Recherche personnalisée</h3>
                <p class="service-description">Notre équipe d'experts vous accompagne dans la recherche de votre bien idéal selon vos critères spécifiques.</p>
            </div>
            <div class="service-card">
                <div class="service-icon">
                    <i class="fas fa-calculator"></i>
                </div>
                <h3 class="service-title">Estimation gratuite</h3>
                <p class="service-description">Bénéficiez d'une estimation précise et gratuite de votre bien immobilier par nos experts certifiés.</p>
            </div>
            <div class="service-card">
                <div class="service-icon">
                    <i class="fas fa-handshake"></i>
                </div>
                <h3 class="service-title">Accompagnement complet</h3>
                <p class="service-description">De la recherche à la signature, nous vous accompagnons à chaque étape de votre projet immobilier.</p>
            </div>
        </div>
    </div>
</section>