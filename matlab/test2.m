id_user = 945;

%   Conexion
    datasource = "AI";
    username = "root";
    password = "";
    vendor = "MySQL";
    conn = database(datasource,username,password,'Vendor',vendor);

%   Params
    selectquery = 'SELECT COUNT(*) AS CUENTA FROM movie';
    data = select(conn,selectquery);  % Total number of movies 
    num_movies = data.CUENTA;
    selectquery = 'SELECT COUNT(*) AS CUENTA FROM users';
    data = select(conn,selectquery);  % Total number of movies 
    num_users = data.CUENTA;
    
    num_features = 3;

%	Cargamos los datos con getData()
    [R,Y,movieList] = getData();
    
%   Inicializo mis puntuaciones
    my_ratings = zeros(num_movies, 1);
    selectquery = strcat('SELECT * FROM user_score WHERE id_user =',int2str(id_user));
    data = select(conn,selectquery);
    for k=1:height(data)
        my_ratings(data.id_movie(k)) = data.score(k);
    end
    
%   Entrenamiento del algoritmo
%   Añade tus puntuaciones a la matriz de datos
    Y = [my_ratings Y];
    R = [(my_ratings ~= 0) R];
    
    num_users = num_users + 1;
    
%   Inicializa parámetros (Theta, X)
    X = randn(num_movies, num_features);
    Theta = randn(num_users, num_features);
    initial_parameters = [X(:); Theta(:)];
    
%   Selecciona las opciones de fmincg
    options = optimset('GradObj', 'on', 'MaxIter', 100);

%   Ajusta regularización y ejecuta la optimización
    lambda = 10;
    theta = fmincg (@(t)(cofiCostFunc(t, Y, R, num_users, num_movies, ...
                                num_features, lambda)), ...
                                initial_parameters, options);

%   Extrae X y Theta del vector resultante de la optimización (theta)
    X = reshape(theta(1:num_movies*num_features), num_movies, num_features);
    Theta = reshape(theta(num_movies*num_features+1:end), ...
                    num_users, num_features);

            
%   Generando recomendaciones
    p = X * Theta';
    my_predictions = p(:,1).*(my_ratings == 0);

%   Actualizando recomendaciones
    status = updateRecommendation(my_predictions, id_user);
    
    