<div id="filesCUF" ng-controller="FilesCtrl">

    <select ng-change="scanPathDir()" ng-model="pathDir" ng-options="dir for dir in directories.data"></select>

    <span ng-if="_.isUndefined(pathDir)&&files.data.length==0"><?php _e("Any file was found in this path",'cuf') ?></span>

    <table ng-if="files.data.length>0"  class="wp-list-table widefat fixed">
        <thead>
        <tr>
            <th class="manage-column column-title">Name</th>
            <th class="manage-column column-title">Size</th>
            <th class="manage-column column-title">Type</th>
            <th class="manage-column column-title">Path</th>
            <th class="manage-column column-title">Attached</th>
            <th class="manage-column column-title">Used</th>
            <th class="manage-column column-title">InServer</th>
            <th class="manage-column column-title">Action</th>
        </tr>
        </thead>
        <tbody>
            <tr ng-repeat="file in files.data">
                <td>{{file.name}}</td>
                <td>{{file.size}}</td>
                <td>{{file.type}}</td>
                <td>{{file.path}}</td>
                <td>
                    <span ng-if="file.status.attach==-1">UNKNOWN</span>
                    <!-- <span ng-if="file.status.attach=="></span> -->
                </td>
                <td>
                    <span ng-if="file.status.used==-1">UNKNOWN</span>
                   <!-- <span ng-if="file.status.used=="></span>-->
                </td>
                <td>
                       <span ng-if="file.status.inServer==-1">UNKNOWN</span>
                   <!-- <span ng-if="file.status.inServer=="></span>-->
                </td>
                <td>

                </td>
            </tr>
        </tbody>


    </table>
</div>