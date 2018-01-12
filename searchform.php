<form role="search" method="get" id="searchform"
    class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>search-page">
    <div>
        <p>
          <label class="screen-reader-text" for="s"><?php _x( 'Search food:', 'label' ); ?></label>
          <input type="text" value="<?php echo get_search_query(); ?>" name="searchquery"/>
        </p>

        <p>
          <label>Type of Food</label>
          <select name="type-of-food" id="type-of-food" style="width: 100%;">
            <option value="">Type of Food</option>
            <?php
              $allTypeOfFood = get_terms(array('type-of-food'));
              foreach ($allTypeOfFood as $typeOfFood) { ?>
                <option value="<?php echo $typeOfFood->name; ?>"><?php echo $typeOfFood->name; ?></option>
              <?php }
            ?>
          </select>
        </p>

        <p>
          <label>Origin of Food</label>
          <select name="origin-of-food" id="origin-of-food" style="width: 100%;">
            <option value="">Origin of Food</option>
            <?php
              $allOriginOfFood = get_terms(array('origin-of-food'));
              foreach ($allOriginOfFood as $originOfFood) { ?>
                <option value="<?php echo $originOfFood->name; ?>"><?php echo $originOfFood->name; ?></option>
              <?php }
            ?>
          </select>
        </p>

        <p>
          <label>Difficulty Level</label><br>
          <select name="difficulty-level-bottom" id="difficulty-level-bottom" style="width: 45%;">
            <option value="">From</option>
            <?php
              $i = 1;
              while ($i <= 10) { ?>
                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
              <?php $i++; }
            ?>
          </select>
          <select name="difficulty-level-up" id="difficulty-level-up" style="width: 45%;">
            <option value="">To</option>
            <?php
              $i = 1;
              while ($i <= 10) { ?>
                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
              <?php $i++; }
            ?>
          </select>
        </p>

        <input type="submit" id="searchsubmit" value="<?php echo esc_attr_x( 'Search Food', 'submit button' ); ?>" />
    </div>
</form>
