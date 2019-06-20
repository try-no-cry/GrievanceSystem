#include<stdio.h>
#include<graphics.h>

void main(){
 int gd=DETECT,gm,code;
 initgraph(&gd,&gm,"C:\\TURBOC3\\BGI");
 code=graphresult();
 if(code!=0){

  printf("Error: %s",grapherrormsg(code));
  getch();

 }
 else{
  int i,x,y;
  x=getmaxx();


  for(i=0;i<x-50;i++){
    line(0+i,30,50+i,30);
    delay(20);
    cleardevice();
  }
    getch();

 }

}