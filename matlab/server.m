import java.net.*;
import java.io.*;

serverSocket = ServerSocket(4450);
display('Iniciando servidor');
try
    while(1)
        socket = serverSocket.accept();
        display('Nueva conexion entrante');
        in = BufferedReader(InputStreamReader(socket.getInputStream()));
        
        %Leemos el path del usuario
        pathstr = in.readLine();
        
        %Leemos la function a ejecutar del usuario 
        funcstr = in.readLine();
        out =PrintWriter(BufferedWriter(OutputStreamWriter(socket.getOutputStream())),true); %Codigo que atiende la peticion
        
        %Establecemos el path del usuario con el valor dice el cliente
        userpath(char(pathstr));
        
        %Evaluamos la funcion que nos dice el cliente
        status=eval(char(funcstr));
        
        %Devolvemos un valor de estado y cerramos out.println(strcat(int2str(status),char(0)));
        out.flush();
        socket.shutdownOutput();
        
        %Restablecemos el path userpath('reset');
        display('cerrando conexion con cliente'); socket.close()
    end
catch e
    e.message
    if(isa(e, 'matlab.exception.JavaException'))
        ex = e.ExceptionObject;
        ex.printStackTrace;
    end
    display('excepcion')
    socket.close();
    serverSocket.close();
end
serverSocket.close();