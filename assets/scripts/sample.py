n=int(input())
set1=set(map(int,input().split()))
set2=set(map(int,input().split()))
set3=set(map(int,input().split()))
if(len(set1)==n):
    if(len(set2)==n):
        if(len(set3)==n):
            print(sum(set1),sum(set2),sum(set3))
        else:
            print("Invalid input")
    else:
        print("Invalid input")
else:
    print("Invalid input")