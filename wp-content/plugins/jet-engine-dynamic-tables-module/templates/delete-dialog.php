<cx-vui-popup
	v-model="isVisible"
	:ok-label="'<?php _e( 'Delete table', 'jet-engine' ) ?>'"
	:cancel-label="'<?php _e( 'Cancel', 'jet-engine' ) ?>'"
	@on-cancel="handleCancel"
	@on-ok="handleOk"
>
	<div class="cx-vui-subtitle" slot="title"><?php
		_e( 'Please confirm table deletion', 'jet-engine' );
	?></div>
	<p slot="content">
		<?php _e( 'Are you sure you want to delete this table? Please ensure you removed it from all pages where it was used.', 'jet-engine' ); ?><br>
	</p>
</cx-vui-popup>
