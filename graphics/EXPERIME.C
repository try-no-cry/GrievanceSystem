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

else{     int i;
  int x=getmaxx();
  int y=getmaxy();
  line(x/2,0,x/2,y);
  line(0,y/2,x,y/2);

  //line
  linerel(30,30);
  lineto(50,100);
  line(45,35,85,35);

  //ellipse
  ellipse(3*x/4,y/4-65,0,360,25,50);
  fillellipse(3*x/4-20,y/4+40,40,20);
  sector(3*x/4+40,y/4+20,0,120,60,30);

  //circle
  circle(x/4,3*y/4,30);
  arc(x/4-80,3*y/4-40,0,250,40);
  pieslice(x/4+80,3*y/4+40,0,75,36);
  //rectangle
  rectangle(3*x/4,3*y/4,3*x/4+50,3*y/4+30);






  getch()    ;
  cleardevice();

}
}