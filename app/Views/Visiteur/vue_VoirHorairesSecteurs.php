<h2><?= esc($TitreDeLaPage) ?></h2>

<div class="container-fluid mt-3">
    <div class="row">
        <div class="col-sm-2 p-2 bg-info text-white">
            <?php foreach ($lesSecteurs as $unSecteur): ?>
                <h3><?= anchor('horaires/'.$unSecteur->NOSECTEUR, esc($unSecteur->NOM)) ?></h3>
            <?php endforeach; ?>
        </div>

        <div class="col-sm-10 p-3">
        <?php if (!empty($noSecteur)): ?>
            <?php if (!empty($lesLiaisons)): ?>
                <?= form_open(current_url()) ?>

                    <label for="liaison">Choisissez une liaison :</label>
                    <select name="liaison" class="form-control" required>
                        <?php foreach ($lesLiaisons as $uneLiaison): ?>
                            <option value="<?= esc($uneLiaison->NOLIAISON) ?>">
                                <?= esc($uneLiaison->PortDepart . " - " . $uneLiaison->PortArrivee) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <label for="date" class="mt-3">Choisissez une date :</label>
                    <select name="date" class="form-control" required>
                        <?php
                        $today = new DateTime();
                        for ($i = 0; $i < 30; $i++):
                            $date = clone $today;
                            $date->modify("+$i day");
                            $val = $date->format('Y-m-d');
                            $text = $date->format('d/m/Y');
                        ?>
                            <option value="<?= $val ?>"><?= $text ?></option>
                        <?php endfor; ?>
                    </select>

                    <input type="submit" name="valid" value="Afficher les traversées" class="btn btn-primary mt-3"/>

                <?= form_close() ?>

                <?php if (!empty($lesTraversees)): ?>
                    <h3 class="mt-4">Traversées disponibles :</h3>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Départ</th><th>Bateau</th><th>Catégorie</th><th>Type</th><th>Places</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($lesTraversees as $traversee): ?>
                            <?php if ($traversee !== null): ?>
                                <tr>
                                <td><?= esc($traversee->DATEHEUREDEPART) ?></td>
                                <td><?= esc($traversee->NOM_BATEAU) ?></td>
                                <td><?= esc($traversee->LETTRECATEGORIE) ?></td>
                                <td><?= esc($traversee->NOTYPE) ?></td>
                                <td><?= esc($traversee->PLACES_DISPO) ?></td>
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>

                        </tbody>
                    </table>
                <?php else: ?>
                    <p>Aucune traversée disponible pour cette date.</p>
                <?php endif; ?>

            <?php else: ?>
                <h3>Aucune liaison trouvée pour ce secteur.</h3>
            <?php endif; ?>
        <?php else: ?>
            <h3>Veuillez sélectionner un secteur dans le menu à gauche.</h3>
        <?php endif; ?>
        </div>
    </div>
</div>
