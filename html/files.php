<div id="filesCUF" ng-controller="FilesCtrl">

    <select ng-change="scanPathDir()"  ng-options="dir for dir in dirs" ng-model="pathDir" >

    </select>

    <span ng-if="!_.isUndefined(pathDir)&&files.length==0"><?php _e("Any file was found in this path",'cuf') ?></span>

    <table ng-if="files.length>0"  class="wp-list-table widefat fixed">
        <thead>
        <tr>
            <th class="manage-column column-title"><?php _e('Name', 'cuf'); ?></th>
            <th class="manage-column column-title"><?php _e('ID', 'cuf'); ?></th>
            <th class="manage-column column-title"><?php _e('Size', 'cuf'); ?></th>
            <th class="manage-column column-title"><?php _e('Type', 'cuf'); ?></th>
            <th class="manage-column column-title"><?php _e('Path', 'cuf'); ?></th>
            <th class="manage-column column-title"><?php _e('Attached', 'cuf'); ?></th>
            <th class="manage-column column-title"><?php _e('Used', 'cuf'); ?></th>
            <th class="manage-column column-title"><?php _e('InServer', 'cuf'); ?></th>
            <th class="manage-column column-title"><?php _e('Action', 'cuf'); ?></th>
        </tr>
        </thead>
        <tbody>
            <tr ng-repeat="file in files">
                <td>{{file.name}} </td>
               <td>
                   <span ng-if="_.isUndefined(file.id)">----</span>
                   <span ng-if="!_.isUndefined(file.id)">{{file.id}}</span>
               </td>
                <td>{{file.size}}</td>
                <td>{{file.type}}</td>
                <td>{{file.path}}</td>
                <td>
                    <span ng-if="file.status.attach==status.ATTACH.UNKNOWN"><?php _e('Unknown', 'cuf'); ?></span>
                    <span ng-if="file.status.attach==status.ATTACH.ASKING"><?php _e('Asking...', 'cuf'); ?></span>
                    <span style="color: #FF0000" ng-if="file.status.attach==status.ATTACH.UNATTACH"><?php _e('Unattach', 'cuf'); ?></span>
                    <span style="color: #00c700" ng-if="file.status.attach==status.ATTACH.ATTACH"><?php _e('Attached', 'cuf'); ?></span>
                    <span ng-if="file.status.attach==status.ATTACH.BACKUP_ATTACH"><?php _e('Making backup...', 'cuf'); ?></span>
                    <span ng-if="file.status.attach==status.ATTACH.DELETING_ATTACH"><?php _e('Deleting...', 'cuf'); ?></span>
                    <span ng-if="file.status.attach==status.ATTACH.DELETED_ATTACH"><?php _e('Deleted', 'cuf'); ?></span>
                    
                </td>
                <td>
                    <span ng-if="file.status.used==status.USED.UNKNOWN"><?php _e('Unknown', 'cuf'); ?></span>
                    <span ng-if="file.status.used==status.USED.ASKING"><?php _e('Asking...', 'cuf'); ?></span>
                    <span style="color: #FF0000" ng-if="file.status.used==status.USED.UNUSED"><?php _e('Unused', 'cuf'); ?></span>
                    <span style="color: #00c700" ng-if="file.status.used==status.USED.USED"><?php _e('Used', 'cuf'); ?></span>
                </td>
                <td>
                    
                    <span ng-if="file.status.inServer==status.IN_SERVER.UNKNOWN"><?php _e('Unknown', 'cuf'); ?></span>
                    <span ng-if="file.status.inServer==status.IN_SERVER.ASKING"><?php _e('Asking...', 'cuf'); ?></span>
                    <span ng-if="file.status.inServer==status.IN_SERVER.NOT_INSERVER" style="color: #FF0000">X</span>
                   <span ng-if="file.status.inServer==status.IN_SERVER.INSERVER" style="color: #00c700">&#10003;</span>
                   
                </td>
                <td>
                    <button ng-if="file.toDelete" ng-click="deleteFile(file)">Delete</button>
                   
                </td>
            </tr>
        </tbody>


    </table>
    
</div>