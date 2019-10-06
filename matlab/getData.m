function [R,Y,movieList] = getData()
%GETDATA Summary of this function goes here
%   Detailed explanation goes here


%Conexion
datasource = "AI";
username = "root";
password = "";
vendor = "MySQL";
conn = database(datasource,username,password,'Vendor',vendor);

%movieList
    % Store all movies in cell array movie{}
    selectquery = 'SELECT COUNT(*) AS CUENTA FROM movie';
    data = select(conn,selectquery);  % Total number of movies 
    n_movies = data.CUENTA;
    selectquery = 'SELECT title FROM movie';
    data = select(conn,selectquery);
    movieList = cell(n_movies, 1);
    for i = 1:n_movies
        movieList{i} = strtrim(data.title(i));
    end

%Y y R
    selectquery = 'SELECT COUNT(*) AS CUENTA FROM users';
    data = select(conn,selectquery);
    n_users = data.CUENTA;
    Y = zeros(n_movies, n_users);
    R = zeros(n_movies, n_users);
    selectquery = 'SELECT * FROM user_score';
    data = select(conn,selectquery);
    for k=1:height(data)
        user = data.id_user(k);
        movie = data.id_movie(k);
        score = data.score(k);
        Y(movie,user) = score;
        R(movie,user) = 1;
    end

end

