<h2><?php echo $TitreDeLaPage ?></h2>

<div class="container-fluid mt-3">

  <div class="row">

    <div class="col-sm-2 p-2 bg-info text-white">
        <?php foreach ($lesSecteurs as $unSecteur) :
            $data['noSecteur'] = $unSecteur->NOSECTEUR;
            echo '<h3>'.anchor('horaires/'.$unSecteur->NOSECTEUR, $unSecteur->NOM).'</h3>';
        endforeach ?>
    </div>

    <div class="col-sm-10 p-10">
    <?php
        if (!empty($noSecteur))
        {
            if (!empty($lesLiaisons)): ?>

                <select>
                    <?php foreach ($lesLiaisons as $uneLiaison): ?>
                        <a class="dropdown-item" href="#">
                            <option>
                                <?= $uneLiaison->PortDepart . " - " . $uneLiaison->PortArrivee ?>
                            </option>
                        </a>
                    <?php endforeach; /*<?= esc($uneLiaison->PortDepart . " - " . $uneLiaison->PortArrivee) ?>*/?>
                </select>

                
                <select>
                    <?php
                        $today = new DateTime();
                        for ($i = 0; $i < 30; $i++) 
                        {
                            $date = clone $today;
                            $date->modify("+$i day");
                            $formattedValue = $date->format('Y-m-d');
                            $formattedText = $date->format('d/m/Y');
                            echo "<option value=\"$formattedValue\">$formattedText</option>";
                        }

            else: ?>
                <h1>Veuillez sélectionner un secteur</h1>
            <?php endif ?>; 

            


            <input type="submit" name="valid" value="Afficher les traversees"/>
            <?php



            // Appel au modèle Traversee pour récupérer les traversées
            if (isset($_POST['valid'])) 
            {
                $noLiaison = $_POST['liaison'];
                $date = $_POST['date'];
  
                $modTraversee = new \App\Models\ModeleTraversee();
                $lesTraversees = $modTraversee->getAllhorairesLiaison($noLiaison, $date);
  
                echo '<h3 class="mt-4">Traversées disponibles :</h3>';
                if (!empty($lesTraversees)) {
                    echo '<table class="table table-bordered">';
                    echo '<thead><tr><th>Départ</th><th>Bateau</th><th>Catégorie</th><th>Type</th><th>Places disponibles</th></tr></thead><tbody>';
                    foreach ($lesTraversees as $traversee) {
                        echo '<tr>';
                        echo '<td>' . $traversee->DATEHEUREDEPART . '</td>';
                        echo '<td>' . $traversee->NOM_BATEAU . '</td>';
                        echo '<td>' . $traversee->LETTRECATEGORIE . '</td>';
                        echo '<td>' . $traversee->NOTYPE . '</td>';
                        echo '<td>' . $traversee->PLACES_DISPO . '</td>';
                        echo '</tr>';
                    }
                    echo '</tbody></table>';
                } 
                else 
                {
                    echo '<p>Aucune traversée disponible pour cette date.</p>';
                }
            }
            else
            {
                echo '<h1>Aucune liaison trouvée pour ce secteur</h1>';
            }
        }
        else
        {
            echo '<h1> Veuillez selectionner un secteur </h1>';
        }
        ?>
    </div>
</div>