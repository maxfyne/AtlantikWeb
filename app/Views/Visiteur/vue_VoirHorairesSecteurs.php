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


            //////////////////////////////////////////////////////
            //////////////CODE POOUR LE MODELE TRAVERSEE////////////////////
            //////////////////////////////////////////////////////
        }
        else
        {
            echo '<h1> Veuillez selectionner un secteur </h1>';
        }
        ?>
    </div>
</div>