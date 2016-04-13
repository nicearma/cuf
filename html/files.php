<div id="filesCUF" ng-controller="FilesCtrl">

    <select ng-change="scanPathDir()"  ng-options="dir for dir in dirs" ng-model="pathDir" >

    </select>

    <span ng-if="!_.isUndefined(pathDir)&&files.length==0"><?php _e("Any file was found in this path",'cuf') ?></span>

    <table ng-if="files.length>0"  class="wp-list-table widefat fixed">
        <thead>
        <tr>
            <th class="manage-column column-title"><?php _e('Name', 'cuf'); ?></th>
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
                <td>{{file.name}}</td>
                <td>{{file.size}}</td>
                <td>{{file.type}}</td>
                <td>{{file.path}}</td>
                <td>
                    <span ng-if="file.status.attach==status.ATTACH.UNKNOWN"><?php _e('unknown', 'cuf'); ?></span>
                    <span ng-if="file.status.attach==status.ATTACH.ASKING"><?php _e('asking...', 'cuf'); ?></span>
            
                </td>
                <td>
                    <span ng-if="file.status.used==status.USED.UNKNOWN"><?php _e('unknown', 'cuf'); ?></span>
                    <span ng-if="file.status.used==status.USED.ASKING"><?php _e('asking...', 'cuf'); ?></span>
                   
                </td>
                <td>
                       <span ng-if="file.status.inServer==status.IN_SERVER.UNKNOWN"><?php _e('unknown', 'cuf'); ?></span>
                   <span ng-if="file.status.inServer==status.IN_SERVER.ASKING"><?php _e('asking...', 'cuf'); ?></span>
                   
                </td>
                <td>

                </td>
            </tr>
        </tbody>


    </table>
</div>