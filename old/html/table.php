<script type="text/template" id="cuf_select_folder" >
   
    <% cCUFFolder.forEach(function(folder){ console.log(folder); %>
    <option class="select-folder" value="<%= folder.get('name') %>"  ><%= folder.get('name') %></option>
    <% }); %>
   
</script>

<script type="text/template" id="cuf_table_files" >
    <thead> 
        <tr>
        <th class="check-column" scope="col"><input disabled id="cuf-select-all" type="checkbox" ></th>
        <th class="manage-column column-title"><?php _e('Name', 'cuf') ?></th>
        <th class="manage-column column-title"><?php _e('Is attachement', 'cuf') ?></th>
        <th class="manage-column column-title"><?php _e('Link of attachement', 'cuf') ?></th>    
        <th class="manage-column column-title"><?php _e('Is used', 'cuf') ?></th>
        <th class="manage-column column-title"><?php _e('Link of used', 'cuf') ?></th>
        </tr>
    </thead>
    <tbody>
    </tbody>
    <tfoot> 
         <tr>
            <th class="check-column" scope="col"><input disabled id="cuf-select-all" type="checkbox" ></th>
            <th class="manage-column column-title"><?php _e('Name', 'cuf') ?></th>
            <th class="manage-column column-title"><?php _e('Is attachement', 'cuf') ?></th>
            <th class="manage-column column-title"><?php _e('Link of attachement', 'cuf') ?></th>    
            <th class="manage-column column-title"><?php _e('Is used', 'cuf') ?></th>
            <th class="manage-column column-title"><?php _e('Link of used', 'cuf') ?></th>
        </tr>
    </tfoot>
</script>

<script type="text/template"  id="cuf_tbody_file">
    <% console.log(mCUFFile); console.log(mCUFOption);  %>
    
            <th class="check-column" >
                <input data-name="<%= mCUFFile.get('fileName') %>" id="" <% if( mCUFFile.get('attachement') || mCUFFile.get('used') ){ %> disabled <% } %> type="checkbox">
            </th>
            <td><%= mCUFFile.get('fileName') %></td>
            <td><% if( mCUFFile.get('attachement') ){ %><?php _e('Yes', 'cuf')?> <% }else{ %> <?php _e('No', 'cuf')?>  <% } %> </td>
            <td><% if( mCUFFile.get('attachement') ){ %><a href="<%= mCUFFile.get('urlAttachement') %>" ><?php _e('URI', 'cuf')?></a> <% }else{ %> ----  <% } %> </td>
            <td><% if( mCUFFile.get('used') ){ %><?php _e('Yes', 'cuf')?> <% }else{ %> <?php _e('No', 'cuf')?>  <% } %> </td>
            <td><% if( mCUFFile.get('used') ){ %><a href="<%= mCUFFile.get('urlUsed') %>" ><?php _e('URI', 'cuf')?></a> <% }else{ %> ----  <% } %> </td>
    
     
    
</script>

<script type="text/template" id="cuf_folder_button">
<h2>
<button class="button-primary cuf_folder_delete right"  type="button"><?php _e('Delete all selected','cuf') ?> </button> 
</h2>
</script>
   
<script type="text/template" id="cuf_wait">
    <h3><?php _e("searching in server, please wait some moment","cuf") ?></h3>
</script>
 
<script type="text/template" id="cuf_nothing_search">
    <h3><?php _e("Nothing found in the search, select other folder","cuf") ?></h3>
</script>
 
<script type="text/template" id="cuf_nothing_backup">
    <h3><?php _e("You dont have backup","cuf") ?></h3>
</script>

<script type="text/template" id="cuf_delete">
    <h3><?php _e("Deleting files from server and database, please wait some moment","cuf") ?></h3>
</script>