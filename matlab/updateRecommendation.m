function [status] = updateRecommendation(predictions, id_user)
%GETDATA Summary of this function goes here
%   Detailed explanation goes here

%Conexion
datasource = "AI";
username = "root";
password = "";
vendor = "MySQL";
conn = database(datasource,username,password,'Vendor',vendor);

    [r, ix] = sort(predictions, 'descend');
    fprintf('\nTop te recomendamos:\n');
    for i=1:3
        insert(conn,'recs',{'user_id','movie_id','rec_score'},{id_user,ix(i),r(i)})
    end

status = 1; %   Todo ha terminado correctamente

end